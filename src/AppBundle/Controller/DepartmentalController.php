<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AdherentResponsability;
use AppBundle\Entity\Adherent;
use AppBundle\Entity\Election\Election;
use AppBundle\Entity\Responsability;
use AppBundle\Form\Election\DepartmentalElectionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Departmental Controller.
 *
 * @Route("/instances-departementales")
 */
class DepartmentalController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/rapporter-resultat", name="departmental_election_result")
     */
    public function submitAction(Request $request)
    {
        $adherent = $this->getUser()->getProfile();

        $this->denyAccessUnlessGranted('DEPARTMENT_ELECTION_REPORT', $adherent);

        //récupérer la responsabilité co sec ou co trésorier
        $responsabilityCoSec = $this->getDoctrine()
            ->getRepository('AppBundle:Responsability')
            ->findOneById($this->container->getParameter('coSecretaire_departement_id'));
        $responsabilityCoTreasure = $this->getDoctrine()
            ->getRepository('AppBundle:Responsability')
            ->findOneById($this->container->getParameter('coTresorier_departement_id'));

        foreach ($adherent->getResponsabilities() as $adherentResponsability) {
            if ($adherentResponsability->getResponsability() == $responsabilityCoSec) {
                $departement = $adherentResponsability->getDesignatedByOrgan();
            }
        }
        if (!isset($departement)) {
            return false;
        }
        $formElection = $this->createForm(
            new DepartmentalElectionType($adherent, $departement)
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

//Nombre d'élus de base
                $numberOfElected = 4;

//Si d'anciens responsables sont cités, leurs responsabilités sont désactivées
                if (isset($departmentalElection['oldCoSecMen'])) {
                    $this->removeOldResponsability($departmentalElection['oldCoSecMen'], $date, $responsabilityCoSec);
                }
                if (isset($departmentalElection['oldCoSecWomen'])) {
                    $this->removeOldResponsability($departmentalElection['oldCoSecMen'], $date, $responsabilityCoSec);
                }
                if (isset($departmentalElection['oldCoTreasureWomen'])) {
                    $this->removeOldResponsability($departmentalElection['oldCoSecMen'], $date, $responsabilityCoTreasure);
                }
                if (isset($departmentalElection['oldCoTreasureMen'])) {
                    $this->removeOldResponsability($departmentalElection['oldCoSecMen'], $date, $responsabilityCoTreasure);
                }

// récupération du type d'élection
                $electionGroup = $this
                    ->getDoctrine()
                    ->getRepository('AppBundle:Election\ElectionGroup')
                    ->findOneBy(array('name' => 'Election Départementale'));

// création de l'élection et des nouveaux élus
                $election = new Election();
                $election->setStatus('Election Fermée');
                $election->setGroup($electionGroup);
                $election->setOrgan($departement);
                $election->setResponsable($adherent);
                $election->setNumberOfVoters($numberOfVoters);
                $election->setValidVotes($validVotes);
                $election->setBlankVotes($blankVotes);
                $election->setIsValid(true);
                $election->setNumberOfElected($numberOfElected);
                $election->setDate($date);

                // début du mandat 1 jour après l'élection
                $dateElection = clone $date;
                $dateElection = $date->modify('+ 1 days');
                $dateEndElection = clone $dateElection;
                $dateEndElection = $date->modify('+ 1 years');

                $newResponsabilities = array(
                    'coSecWomen' => $responsabilityCoSec,
                    'coSecMen' => $responsabilityCoSec,
                    'coTreasureWomen' => $responsabilityCoTreasure,
                    'coTreasureMen' => $responsabilityCoTreasure,
                );

                foreach ($newResponsabilities as $newResponsableKey => $newResponsability) {
                    $newAR = new AdherentResponsability();
                    $newAR->setAdherent($departmentalElection[$newResponsableKey]);
                    $newAR->setResponsability($newResponsability);
                    $newAR->setStart($dateElection);
                    $newAR->setEnd($dateEndElection);
                    $newAR->setIsActive(true);
                    $newAR->setDesignatedByOrgan($departement);
                    $manager->persist($newAR);

                    $election->addElected($newAR);
                }

                // Ajout des postes fonctionnels s'ils existent
                for ($i=1; $i < 7; $i++) {
                    if (isset($departmentalElection['responsability' . $i])) {
                        $responsability = $departmentalElection['responsability' . $i];
                        if ($departmentalElection['responsable' . $i]) {
                            $responsable = $departmentalElection['responsable' . $i];

                            $ar = new AdherentResponsability();
                            $ar->setAdherent($responsable);
                            $ar->setResponsability($responsability);
                            $ar->setIsActive(true);
                            $ar->setStart($dateElection);
                            $ar->setEnd($dateEndElection);
                            $ar->setDesignatedByOrgan($departement);
                            $manager->persist($ar);

                            $election->addElected($ar);
                        }
                    }
                }

                $manager->persist($election);
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
            'adherent' => $adherent,
        ));
    }

    protected function removeOldResponsability(Adherent $adherent, $date, Responsability $responsability) {
        $oldAdherentResponsabilities = $this
            ->getDoctrine()
            ->getRepository('AppBundle:AdherentResponsability')
            ->findOldResponsabilityByAdherentAndResponsability($adherent, $date, $responsability);

        if (isset($oldAdherentResponsabilities)) {
            foreach ($oldAdherentResponsabilities as $oldAdherentResponsability) {
                $oldAdherentResponsability->setIsActive(false);
                $this->getDoctrine()->getManager()->persist($oldAdherentResponsability);
            }
        }
    }
}
