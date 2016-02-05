<?php

namespace AppBundle\Security;

use AppBundle\Entity\Process\AmendmentProcess;
use AppBundle\Entity\Organ\Organ;
use AppBundle\Entity\User;
use AppBundle\Entity\Adherent;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;

final class AmendmentProcessVoter extends AbstractVoter
{
    const VIEW = 'view';

    const REPORT_AMEND = 'report_amend';

    private $entityManager;
    private $container;

    protected function getSupportedAttributes()
    {
        return array(self::VIEW, self::REPORT_AMEND);
    }

    protected function getSupportedClasses()
    {
        return array('AppBundle\Entity\Process\AmendmentProcess');
    }

    protected function isGranted($attribute, $amendmentProcess, $user = null)
    {
        $em = $this->entityManager;
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($attribute === self::VIEW) {
            return $this->canView($amendmentProcess, $user);
        }

        if ($attribute === self::REPORT_AMEND) {
            return $this->canView($amendmentProcess, $user)
                && $this->canReportAmend($amendmentProcess, $user->getProfile());
        }

        return false;
    }

    private function canView(AmendmentProcess $amendmentProcess, User $user)
    {
        // FIXME : in_array does not take into account role hierarchy !
        return ($amendmentProcess->getIsVisible() ||
            in_array('ROLE_ADMIN', $user->getRoles(), true));
    }

    /*
     * a adherent can amend a text if :
     * - text Group is open for vote (done)
     * - the adherent as as the right responsability to report vote.(done, some limitations)
     */
    private function canReportAmend(AmendmentProcess $amendmentProcess, Adherent $adherent)
    {
        $date = new \DateTime('now');
        $em = $this->entityManager;

        foreach($amendmentProcess->getParticipationRule()->getParticipationRuleTerms() as $term) {
            $termResponsability = $term->getResponsability();
            $termOrganType = $term->getOrganType();

            foreach ($adherent->getResponsabilities() as $adherentResponsability) {

                $canReportAmend = (
                    isset($termResponsability)
                        ? ($adherentResponsability->getResponsability() == $termResponsability)
                        : true
                ) && (
                    isset($termOrganType)
                        ? ($adherentResponsability->getDesignatedByOrgan()->getOrganType() == $termOrganType)
                        : true
                );

                if ($canReportAmend) {
                    return true;
                }
            }
        }

        return false;
    }

    public function __construct($entityManager, $container)
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
    }
}
