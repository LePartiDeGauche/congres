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
                $name = $departmentalElection['name'];
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



                dump($departmentalElection);die;

                $election = new Election();
                $election->setStatus('STATUS_CLOSED');
                $election->setResponsable($adherent);
                $election->setNumberOfVoters($numberOfVoters);
                $election->setValidVotes($validVotes);
                $election->setBlankVotes($blankVotes);

                $newCoSecWomen = new AdherentResponsability();
                $newCoSecWomen->setAdherent($coSecWomen);
                $newCoSecWomen->setResponsability('INSTANCE_COSEC_DEPARTMENT');
                $newCoSecWomen->setStart($date);
                $newCoSecWomen->setIsActive(true);

                $newCoSecMen = new AdherentResponsability();
                $newCoSecMen->setAdherent($coSecMen);
                $newCoSecMen->setResponsability('INSTANCE_COSEC_DEPARTMENT');
                $newCoSecMen->setStart($date);
                $newCoSecMen->setIsActive(true);

                if ($oldCoSecMen) {

                }


                $responsability = new Responsability();

                $manager->persist($formElection->getData());
                $manager->flush();

                $this
                    ->get('session')
                    ->getFlashBag()
                    ->add(
                        'success',
                        'Résultat bien enregistré.'
                    )
                ;

                return $this->redirect($this->generateUrl('election_list'));
            }

        }

        return $this->render('election/departmental_result_submit.html.twig', array(
            'form' => $formElection->createView(),
            "adherent" => $adherent
        ));
    }
}