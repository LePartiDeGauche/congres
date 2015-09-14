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

        $this->denyAccessUnlessGranted('DEPARTMENT_ELECTION_REPORT', $adherent);

        $formElection = $this->createForm(
            new DepartmentalElectionType($adherent)
        );

        $formElection->handleRequest($request);
        if ($formElection->isSubmitted()) {
            $formElection->getData();

            if ($formElection->isValid()) {
                $manager = $this->getDoctrine()->getManager();


                $departmentalElection = $formElection->getData();

//données du formulaire obligatoires : date, élus
                $date = $departmentalElection['date'];
                $numberOfVoters = $departmentalElection['numberOfVoters'];
                $validVotes = $departmentalElection['validVotes'];
                $blankVotes = $departmentalElection['blankVotes'];
                $coSecWomen = $departmentalElection['coSecWomen'];
                $coSecMen = $departmentalElection['coSecMen'];
                $coTreasureWomen = $departmentalElection['coTreasureWomen'];
                $coTreasureMen = $departmentalElection['coTreasureMen'];


//récupérer la responsabilité co sec ou co trésorier
                $responsabilityCoSec = $this->getDoctrine()->getRepository('AppBundle:Responsability')->findOneByName('Co-secrétaire départemental');
                $responsabilityCoTreasure= $this->getDoctrine()->getRepository('AppBundle:Responsability')->findOneByName('Co-trésorier départemental');

//Nombre d'élus de base
                $numberOfElected = 4;

//Si d'anciens responsables sont cités, leurs responsabilités sont désactivées
                if ($departmentalElection['oldCoSecMen']) {
                    $oldCoSecMen = $departmentalElection['oldCoSecMen'];
                    $numberOfElected++;

                    $oldAdherentResponsability = $this
                        ->getDoctrine()
                        ->getRepository('AppBundle:AdherentResponsability')
                        ->findOldResponsabilityByAdherentAndResponsability($oldCoSecMen, $date, $responsabilityCoSec);

                    if ($oldAdherentResponsability)
                    {
                        foreach($oldAdherentResponsability as $key)
                        {
                            $key->setIsActive(false);
                            $manager->persist($key);
                        }
                    }
                    }
                    if ($departmentalElection['oldCoSecWomen']) {
                        $oldCoSecWomen = $departmentalElection['oldCoSecWomen'];
                        $numberOfElected++;

                        $oldAdherentResponsability = $this
                            ->getDoctrine()
                            ->getRepository('AppBundle:AdherentResponsability')
                            ->findOldResponsabilityByAdherentAndResponsability($oldCoSecWomen, $date, $responsabilityCoSec);

                        if ($oldAdherentResponsability)
                        {
                            foreach($oldAdherentResponsability as $key)
                            {
                                $key->setIsActive(false);
                                $manager->persist($key);
                            }
                        }
                    }
                    if ($departmentalElection['oldCoTreasureWomen']) {
                        $oldCoTreasureWomen = $departmentalElection['oldCoTreasureWomen'];
                        $numberOfElected++;

                        $oldAdherentResponsability = $this
                            ->getDoctrine()
                            ->getRepository('AppBundle:AdherentResponsability')
                            ->findOldResponsabilityByAdherentAndResponsability($oldCoTreasureWomen, $date, $responsabilityCoTreasure);

                        if ($oldAdherentResponsability)
                        {
                            foreach($oldAdherentResponsability as $key)
                            {
                                $key->setIsActive(false);
                                $manager->persist($key);
                            }
                        }
                    }
                    if ($departmentalElection['oldCoTreasureMen']) {
                        $oldCoTreasureMen = $departmentalElection['oldCoTreasureMen'];
                        $numberOfElected++;

                        $oldAdherentResponsability = $this
                            ->getDoctrine()
                            ->getRepository('AppBundle:AdherentResponsability')
                            ->findOldResponsabilityByAdherentAndResponsability($oldCoTreasureMen, $date, $responsabilityCoTreasure);

                        if ($oldAdherentResponsability)
                        {
                            foreach($oldAdherentResponsability as $key)
                            {
                                $key->setIsActive(false);
                                $manager->persist($key);
                            }
                        }
                    }


// création de l'élection et des nouveaux élus
                $election = new Election();
                $election->setStatus('Election Fermée');
                $election->setResponsable($adherent);
                $election->setNumberOfVoters($numberOfVoters);
                $election->setValidVotes($validVotes);
                $election->setBlankVotes($blankVotes);
                $election->setIsValid(true);
                $election->setNumberOfElected($numberOfElected);

                // début du mandat 1 jour après l'élection
                $dateElection = clone $date;
                $dateElection = $date->modify("+ 1 days");

                $newCoSecWomen = new AdherentResponsability();
                $newCoSecWomen->setAdherent($coSecWomen);
                $newCoSecWomen->setResponsability($responsabilityCoSec);
                $newCoSecWomen->setStart($dateElection);
                $newCoSecWomen->setIsActive(true);

                $newCoSecMen = new AdherentResponsability();
                $newCoSecMen->setAdherent($coSecMen);
                $newCoSecMen->setResponsability($responsabilityCoSec);
                $newCoSecMen->setStart($dateElection);
                $newCoSecMen->setIsActive(true);

                $newCoTreasureWomen = new AdherentResponsability();
                $newCoTreasureWomen->setAdherent($coTreasureWomen);
                $newCoTreasureWomen->setResponsability($responsabilityCoTreasure);
                $newCoTreasureWomen->setStart($dateElection);
                $newCoTreasureWomen->setIsActive(true);

                $newCoTreasureMen = new AdherentResponsability();
                $newCoTreasureMen->setAdherent($coTreasureMen);
                $newCoTreasureMen->setResponsability($responsabilityCoTreasure);
                $newCoTreasureMen->setStart($dateElection);
                $newCoTreasureMen->setIsActive(true);

                $manager->persist($election);
                $manager->persist($newCoSecWomen);
                $manager->persist($newCoSecMen);
                $manager->persist($newCoTreasureWomen);
                $manager->persist($newCoTreasureMen);

// Ajout des postes fonctionnels s'ils existent
                if ($departmentalElection['responsability1']) {
                    $responsability1 = $departmentalElection['responsability1'];
                    if ($departmentalElection['responsable1']) {
                        $responsable1 = $departmentalElection['responsable1'];

                        $responsability = new Responsability();
                        $responsability->setName($responsability1);

                        $adherentResponsability = new AdherentResponsability();
                        $adherentResponsability->setAdherent($responsable1);
                        $adherentResponsability->setResponsability($responsability);
                        $adherentResponsability->setIsActive(true);
                        $adherentResponsability->setStart($dateElection);

                        $manager->persist($adherentResponsability);
                        $manager->persist($responsability);
                    }
                }

                if ($departmentalElection['responsability2']) {
                    $responsability2 = $departmentalElection['responsability2'];
                    if ($departmentalElection['responsable2']) {
                        $responsable2 = $departmentalElection['responsable2'];

                        $responsability = new Responsability();
                        $responsability->setName($responsability2);

                        $adherentResponsability = new AdherentResponsability();
                        $adherentResponsability->setAdherent($responsable2);
                        $adherentResponsability->setResponsability($responsability);
                        $adherentResponsability->setIsActive(true);
                        $adherentResponsability->setStart($dateElection);

                        $manager->persist($adherentResponsability);
                        $manager->persist($responsability);
                    }
                }

                if ($departmentalElection['responsability3']) {
                    $responsability3 = $departmentalElection['responsability3'];
                    if ($departmentalElection['responsable3']) {
                        $responsable3 = $departmentalElection['responsable3'];

                        $responsability = new Responsability();
                        $responsability->setName($responsability3);

                        $adherentResponsability = new AdherentResponsability();
                        $adherentResponsability->setAdherent($responsable3);
                        $adherentResponsability->setResponsability($responsability);
                        $adherentResponsability->setIsActive(true);
                        $adherentResponsability->setStart($dateElection);

                        $manager->persist($adherentResponsability);
                        $manager->persist($responsability);
                    }
                }

                if ($departmentalElection['responsability4']) {
                    $responsability4 = $departmentalElection['responsability4'];
                    if ($departmentalElection['responsable4']) {
                        $responsable4 = $departmentalElection['responsable4'];

                        $responsability = new Responsability();
                        $responsability->setName($responsability4);

                        $adherentResponsability = new AdherentResponsability();
                        $adherentResponsability->setAdherent($responsable4);
                        $adherentResponsability->setResponsability($responsability);
                        $adherentResponsability->setIsActive(true);
                        $adherentResponsability->setStart($dateElection);

                        $manager->persist($adherentResponsability);
                        $manager->persist($responsability);
                    }
                }

                if ($departmentalElection['responsability5']) {
                    $responsability5 = $departmentalElection['responsability5'];
                    if ($departmentalElection['responsable5']) {
                        $responsable5 = $departmentalElection['responsable5'];

                        $responsability = new Responsability();
                        $responsability->setName($responsability5);

                        $adherentResponsability = new AdherentResponsability();
                        $adherentResponsability->setAdherent($responsable5);
                        $adherentResponsability->setResponsability($responsability);
                        $adherentResponsability->setIsActive(true);
                        $adherentResponsability->setStart($dateElection);

                        $manager->persist($adherentResponsability);
                        $manager->persist($responsability);
                    }
                }

                if ($departmentalElection['responsability5']) {
                    $responsability5 = $departmentalElection['responsability5'];
                    if ($departmentalElection['responsable5']) {
                        $responsable5 = $departmentalElection['responsable5'];

                        $responsability = new Responsability();
                        $responsability->setName($responsability5);

                        $adherentResponsability = new AdherentResponsability();
                        $adherentResponsability->setAdherent($responsable5);
                        $adherentResponsability->setResponsability($responsability);
                        $adherentResponsability->setIsActive(true);
                        $adherentResponsability->setStart($dateElection);

                        $manager->persist($adherentResponsability);
                        $manager->persist($responsability);
                    }
                }




//
//
//                //Responsability co-secrétaire
//                $responsability = $this
//                    ->getDoctrine()
//                    ->getRepository('AppBundle:Responsability')
//                    ->findByName('Co-secrétaire départemental');
//
//                //Réupération d'une responsabilité par adhérent si active
//                $adherentResponsability = $this
//                    ->getDoctrine()
//                    ->getRepository('AppBundle:AdherentResponsability')
//                    ->findActiveResponsabilityByAdherent($adherent, $responsability);
//
//                //Si l'user courant est un co-secrétaire actif
//                if($adherentResponsability) {
//                    foreach ($adherentResponsability as $key) {
//                        $responsabilityAdherent = $key->getResponsability();
//                    }
//                    foreach($responsability as $key)
//                    {
//                        $responsability = $key;
//                    }
//
//                    if ($responsabilityAdherent == $responsability)
//                    {
//                        echo 'good';
//                    }
//                    else
//                    {
//                        echo 'resp existe mais match pas';
//                    }
//                }
//                else
//                {
//                    echo 'aucune resp active';
//                }
//
//                die;

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