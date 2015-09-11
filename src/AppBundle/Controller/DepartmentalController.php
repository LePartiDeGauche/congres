<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Adherent;
use AppBundle\Entity\AdherentResponsability;
use AppBundle\Entity\Organ;
use AppBundle\Entity\Election\Election;
use AppBundle\Entity\Responsability;
use AppBundle\Form\Election\DepartmentalElectionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class Departmental Controller
 *
 * @Route("/instances-departementales")
 */
class DepartmentalController extends Controller
{

    /**
     * @param Request  $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/rapporter-resultat", name="departmental_election_result")
     */
    public function submitAction(Request $request)
    {
        $adherent = $this->getUser()->getProfile();

        $formElection = $this->createForm(
            new DepartmentalElectionType($adherent)
        );

        $formElection->handleRequest($request);
        if ($formElection->isSubmitted()) {
            $formElection->getData();

            if ($formElection->isValid()) {
                $manager = $this->getDoctrine()->getManager();


                $departmentalElection = $formElection->getData();

//données du formulaire
                $date = $departmentalElection['date'];
                $numberOfVoters = $departmentalElection['numberOfVoters'];
                $validVotes = $departmentalElection['validVotes'];
                $blankVotes = $departmentalElection['blankVotes'];
                $coSecWomen = $departmentalElection['coSecWomen'];
                $oldCoSecWomen = $departmentalElection['oldCoSecWomen'];
                $coSecMen = $departmentalElection['coSecMen'];
                $oldCoSecMen = $departmentalElection['oldCoSecMen'];
                $coTreasureWomen = $departmentalElection['coTreasureWomen'];
                $oldCoTreasureWomen = $departmentalElection['oldCoTreasureWomen'];
                $coTreasureMen = $departmentalElection['coTreasureMen'];
                $oldCoTreasureMen = $departmentalElection['oldCoTreasureMen'];


//récupérer la responsabilité co sec ou co trésorier
                $responsabilityCoSec = $this->getDoctrine()->getRepository('AppBundle:Responsability')->findOneByName('Co-secrétaire départemental');
                $responsabilityCoTreasure= $this->getDoctrine()->getRepository('AppBundle:Responsability')->findOneByName('Co-trésorier départemental');

                $numberOfElected = 4;
                $currentDate = new \DateTime(null, new \DateTimeZone('Europe/Paris'));


//Si d'anciens responsables sont cités, leurs responsabilités sont désactivées
                if ($oldCoSecMen) {
                    $numberOfElected++;

                    $oldAdherentResponsability = $this
                        ->getDoctrine()
                        ->getRepository('AppBundle:AdherentResponsability')
                        ->findOldResponsabilityByAdherentAndResponsability($oldCoSecMen, $currentDate, $responsabilityCoSec);

                    if ($oldAdherentResponsability)
                    {
                        foreach($oldAdherentResponsability as $key)
                        {
                            $key->setIsActive(false);
                            $manager->persist($key);
                        }
                    }
                    }
                    if ($oldCoSecWomen) {
                        $numberOfElected++;

                        $oldAdherentResponsability = $this
                            ->getDoctrine()
                            ->getRepository('AppBundle:AdherentResponsability')
                            ->findOldResponsabilityByAdherentAndResponsability($oldCoSecWomen, $currentDate, $responsabilityCoSec);

                        if ($oldAdherentResponsability)
                        {
                            foreach($oldAdherentResponsability as $key)
                            {
                                $key->setIsActive(false);
                                $manager->persist($key);
                            }
                        }
                    }
                    if ($oldCoTreasureWomen) {
                        $numberOfElected++;

                        $oldAdherentResponsability = $this
                            ->getDoctrine()
                            ->getRepository('AppBundle:AdherentResponsability')
                            ->findOldResponsabilityByAdherentAndResponsability($oldCoTreasureWomen, $currentDate, $responsabilityCoTreasure);

                        if ($oldAdherentResponsability)
                        {
                            foreach($oldAdherentResponsability as $key)
                            {
                                $key->setIsActive(false);
                                $manager->persist($key);
                            }
                        }
                    }
                    if ($oldCoTreasureMen) {
                        $numberOfElected++;

                        $oldAdherentResponsability = $this
                            ->getDoctrine()
                            ->getRepository('AppBundle:AdherentResponsability')
                            ->findOldResponsabilityByAdherentAndResponsability($oldCoTreasureMen, $currentDate, $responsabilityCoTreasure);

                        if ($oldAdherentResponsability)
                        {
                            foreach($oldAdherentResponsability as $key)
                            {
                                $key->setIsActive(false);
                                $manager->persist($key);
                            }
                        }
                    }

//Création des postes fonctionnels si c'est derniers existent



// création de l'élection et des nouveaux élus
                $election = new Election();
                $election->setStatus('Election Fermée');
                $election->setResponsable($adherent);
                $election->setNumberOfVoters($numberOfVoters);
                $election->setValidVotes($validVotes);
                $election->setBlankVotes($blankVotes);
                $election->setIsValid(true);
                $election->setNumberOfElected($numberOfElected);

                $newCoSecWomen = new AdherentResponsability();
                $newCoSecWomen->setAdherent($coSecWomen);
                $newCoSecWomen->setResponsability($responsabilityCoSec);
                $newCoSecWomen->setStart($date);
                $newCoSecWomen->setIsActive(true);

                $newCoSecMen = new AdherentResponsability();
                $newCoSecMen->setAdherent($coSecMen);
                $newCoSecMen->setResponsability($responsabilityCoSec);
                $newCoSecMen->setStart($date);
                $newCoSecMen->setIsActive(true);

                $newCoTreasureWomen = new AdherentResponsability();
                $newCoTreasureWomen->setAdherent($coTreasureWomen);
                $newCoTreasureWomen->setResponsability($responsabilityCoTreasure);
                $newCoTreasureWomen->setStart($date);
                $newCoTreasureWomen->setIsActive(true);

                $newCoTreasureMen = new AdherentResponsability();
                $newCoTreasureMen->setAdherent($coTreasureMen);
                $newCoTreasureMen->setResponsability($responsabilityCoTreasure);
                $newCoTreasureMen->setStart($date);
                $newCoTreasureMen->setIsActive(true);

                $manager->persist($election);
                $manager->persist($newCoSecWomen);
                $manager->persist($newCoSecMen);
                $manager->persist($newCoTreasureWomen);
                $manager->persist($newCoTreasureMen);


                $manager->flush();

                $this
                    ->get('session')
                    ->getFlashBag()
                    ->add(
                        'success',
                        'Résultat bien enregistré.'
                    )
                ;

                return $this->redirect($this->generateUrl('homepage'));
            }

        }

        return $this->render('election/departmental_result_submit.html.twig', array(
            'form' => $formElection->createView(),
            "adherent" => $adherent
        ));
    }
}