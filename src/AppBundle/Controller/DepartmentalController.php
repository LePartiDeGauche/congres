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

        $responsabilityDelegateCNTitulaire = $this->getDoctrine()
                ->getRepository('AppBundle:Responsability')
                ->findOneByName('Conseil National');
        $responsabilityDelegateCNSuppleant = $this->getDoctrine()
                ->getRepository('AppBundle:Responsability')
                ->findOneByName('Délégué CN suppléant');

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

                $date = isset($departmentalElection['date'])
                      ? $departmentalElection['date']
                      : new Date('today');

                //Nombre d'élus de base
                $numberOfElected = 0;

                if (isset($departmentalElection['numberOfVoters'])) {
                    $numberOfVoters = $departmentalElection['numberOfVoters'];
                }
                if (isset($departmentalElection['validVotes'])) {
                    $validVotes = $departmentalElection['validVotes'];
                }
                if (isset($departmentalElection['blankVotes'])) {
                    $blankVotes = $departmentalElection['blankVotes'];
                }
                if (isset($departmentalElection['coSecWomen'])) {
                    $coSecWomen =$departmentalElection['coSecWomen'];
                    $numberOfElected++;
                }
                if (isset($departmentalElection['coSecMen'])) {
                    $coSecMen = $departmentalElection['coSecMen'];
                    $numberOfElected++;
                }
                if (isset($departmentalElection['coTreasureWomen'])) {
                    $coTreasureWomen = $departmentalElection['coTreasureWomen'];
                    $numberOfElected++;
                }
                if (isset($departmentalElection['coTreasureMen'])) {
                    $coTreasureMen = $departmentalElection['coTreasureMen'];
                    $numberOfElected++;
                }

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
                if (isset($numberOfVoters)) {
                    $election->setNumberOfVoters($numberOfVoters);
                }
                if (isset($validVotes)) {
                    $election->setValidVotes($validVotes);
                }
                if (isset($blankVotes)) {
                    $election->setBlankVotes($blankVotes);
                }
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
                    if (isset($departmentalElection[$newResponsableKey])) {
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
                }

                for ($i=1; $i < 18; $i++) {
                    if (isset($departmentalElection['delegueCNTitulaire' . $i])) {
                        $responsability = $responsabilityDelegateCNTitulaire;
                        $responsable = $departmentalElection['delegueCNTitulaire' . $i];

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

                for ($i=1; $i < 18; $i++) {
                    if (isset($departmentalElection['delegueCNSuppleant' . $i])) {
                        $responsability = $responsabilityDelegateCNSuppleant;
                        $responsable = $departmentalElection['delegueCNSuppleant' . $i];

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

                // Ajout des postes fonctionnels s'ils existent
                for ($i=1; $i < 7; $i++) {
                    if (isset($departmentalElection['responsability' . $i])) {
                        $responsability = $departmentalElection['responsability' . $i];
                        if (isset($departmentalElection['responsable' . $i])) {
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
