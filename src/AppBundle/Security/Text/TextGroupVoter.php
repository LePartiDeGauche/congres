<?php
namespace AppBundle\Security\Text;

use AppBundle\Entity\Text\TextGroup;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;

final class TextGroupVoter extends AbstractVoter
{
    const VIEW = 'view';

    const CREATE_TEXT = 'create_text';


    const VOTE = 'vote';

    private $entityManager;
    private $container;

    protected function getSupportedAttributes()
    {
        return array(self::VIEW, self::CREATE_TEXT, self::VOTE);
    }

    protected function getSupportedClasses()
    {
        return array('AppBundle\Entity\Text\TextGroup');
    }

    protected function isGranted($attribute, $textGroup, $user = null)
    {
        $em = $this->entityManager;
        if (!$user instanceof UserInterface) {
            return false;
        }
        $date = new \DateTime('now');

        if ($attribute === self::VIEW) {
            return ($textGroup->getIsVisible() ||
                in_array('ROLE_ADMIN', $user->getRoles(), true));
        }

        if ($attribute === self::CREATE_TEXT) {

            return ($textGroup->getIsVisible() && $textGroup->getSubmissionOpening() < $date && $textGroup->getSubmissionClosing() > $date) ||
                in_array('ROLE_ADMIN', $user->getRoles(), true);
        }

        if ($attribute === self::VOTE) {
            $em = $this->entityManager;

            if ($textGroup->getIsVisible() && $textGroup->getVoteOpening() < $date && $textGroup->getVoteClosing() > $date)
            {
                return $em->getRepository('AppBundle:Vote\IndividualTextVote')
                    ->getAdherentVoteCountByTextGroup($user->getProfile(), $textGroup) < 
                    $textGroup->getMaxVotesByAdherent() &&
                    $em->getRepository('AppBundle:Vote\VoteRule')
                    ->getAdherentRightToVoteForTextGroup($user->getProfile(), $textGroup);
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
