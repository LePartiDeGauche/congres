<?php

namespace AppBundle\Security\Text;

use AppBundle\Entity\Text\TextGroup;
use AppBundle\Entity\Organ\Organ;
use AppBundle\Entity\User;
use AppBundle\Entity\Adherent;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;

final class TextGroupVoter extends AbstractVoter
{
    const VIEW = 'view';

    const CREATE_TEXT = 'create_text';

    const VOTE = 'vote';

    const REPORT_VOTE = 'report_vote';

    const REPORT_AMEND = 'report_amend';

    private $entityManager;
    private $container;

    protected function getSupportedAttributes()
    {
        return array(self::VIEW, self::CREATE_TEXT, self::VOTE, self::REPORT_VOTE, self::REPORT_AMEND);
    }

    protected function getSupportedClasses()
    {
        return array('AppBundle\Entity\Text\TextGroup', 'AppBundle\TextGroupOrganPair');
    }

    protected function isGranted($attribute, $textGroup, $user = null)
    {
        $em = $this->entityManager;
        if (!$user instanceof UserInterface) {
            return false;
        }
        $date = new \DateTime('now');

        if ($attribute === self::VIEW) {
            return $this->canView($textGroup, $user);
        }

        if ($attribute === self::CREATE_TEXT) {
            return $this->canCreateText($textGroup, $user);
        }

        if ($attribute === self::VOTE) {
            return $this->canVote($textGroup, $user);
        }

        if ($attribute === self::REPORT_VOTE) {
            return $this->canReportVote($textGroup->getTextGroup(), $user->getProfile(), $textGroup->getOrgan());
        }

        if ($attribute === self::REPORT_AMEND) {
            return $this->canReportAmend($textGroup->getTextGroup(), $user->getProfile(), $textGroup->getOrgan());
        }

        return false;
    }

    private function canView(TextGroup $textGroup, User $user)
    {
        // FIXME : in_array does not take into account role hierarchy !
        return ($textGroup->getIsVisible() ||
            in_array('ROLE_ADMIN', $user->getRoles(), true));
    }

    private function canCreateText(TextGroup $textGroup, User $user)
    {
        $date = new \DateTime('now');
        // FIXME : in_array does not take into account role hierarchy !
        return ($textGroup->getIsVisible() && $textGroup->getSubmissionOpening() < $date && $textGroup->getSubmissionClosing() > $date) ||
            in_array('ROLE_ADMIN', $user->getRoles(), true);
    }

    private function canVote(TextGroup $textGroup, User $user)
    {
        $date = new \DateTime('now');
        $em = $this->entityManager;

        if ($textGroup->getIsVisible() && $textGroup->getVoteOpening() < $date && $textGroup->getVoteClosing() > $date) {
            return $textGroup->getVoteType() == TextGroup::VOTETYPE_INDIVIDUAL && $em->getRepository('AppBundle:Vote\IndividualTextVote')
                ->getAdherentVoteCountByTextGroup($user->getProfile(), $textGroup) <
                $textGroup->getMaxVotesByAdherent() &&
                $em->getRepository('AppBundle:Vote\VoteRule')
                ->getAdherentRightToVoteForTextGroup($user->getProfile(), $textGroup);
        }

        return false;
    }

    /*
     * a adherent can report a vote if :
     * - text Group is open for vote (done)
     * - the organ is abilitated to vote. (done)
     * - the organ has not voted yet. (done)
     * - the adherent as as the right responsability to vote.(done, some limitations)
     */
    private function canReportVote(TextGroup $textGroup, Adherent $adherent, Organ $organ)
    {
        $date = new \DateTime('now');
        $em = $this->entityManager;

        if ($textGroup->getIsVisible() && $textGroup->getVoteOpening() < $date && $textGroup->getVoteClosing() > $date) {
            return
                $em->getRepository('AppBundle:Vote\OrganVoteRule')->getOrganTypeRightToVoteForTextGroup($organ->getOrganType(), $textGroup) &&
                !$em->getRepository('AppBundle:Vote\IndividualOrganTextVote')->hasVoteBeenReported($organ, $textGroup) &&
                ($em->getRepository('AppBundle:Vote\OrganVoteRule')->getAdherentRightToReportForOrganAndTextGroup($adherent, $organ, $textGroup));
        }

        return false;
    }

    /*
     * a adherent can amend a text if :
     * - text Group is open for vote (done)
     * - the adherent as as the right responsability to report vote.(done, some limitations)
     */
    private function canReportAmend(TextGroup $textGroup, Adherent $adherent, Organ $organ)
    {
        $date = new \DateTime('now');
        $em = $this->entityManager;

        if ($textGroup->getIsVisible() && $textGroup->getVoteOpening() < $date && $textGroup->getVoteClosing() > $date) {
            return
                $em->getRepository('AppBundle:Vote\OrganVoteRule')->getOrganTypeRightToVoteForTextGroup($organ->getOrganType(), $textGroup) &&
                ($em->getRepository('AppBundle:Vote\OrganVoteRule')->getAdherentRightToReportForOrganAndTextGroup($adherent, $organ, $textGroup));
        }

        return false;
    }

    public function __construct($entityManager, $container)
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
    }
}
