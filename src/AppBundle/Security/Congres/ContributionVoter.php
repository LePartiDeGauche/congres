<?php
namespace AppBundle\Security\Congres;

use AppBundle\Entity\Congres\Contribution;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ContributionVoter extends AbstractVoter
{
    const VIEW = 'view';

    const DELETE = 'delete';

    const VOTE = 'vote';

    private $entityManager;
    private $container;

    protected function getSupportedAttributes()
    {
        return array(self::VIEW, self::DELETE, self::VOTE);
    }

    protected function getSupportedClasses()
    {
        return array('AppBundle\Entity\Congres\Contribution');
    }

    protected function isGranted($attribute, $contrib, $user = null)
    {
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->container->get('security.context')->isGranted('CALENDAR_contribution_submit')
        || $this->container->get('security.context')->isGranted('CALENDAR_contribution_vote')) {
            if ($attribute === self::VIEW) {
                if (Contribution::STATUS_NEW === $contrib->getStatus()) {
                    return ($user === $contrib->getAuthor() || in_array('ROLE_ADMIN', $user->getRoles(), true));
                }

                return true;
            }

            if ($attribute === self::DELETE) {
                if (Contribution::STATUS_NEW === $contrib->getStatus()) {
                    return ($user === $contrib->getAuthor() || in_array('ROLE_ADMIN', $user->getRoles(), true));
                }

                return in_array('ROLE_ADMIN', $user->getRoles(), true);
            }

            if ($attribute === self::VOTE) {
                if (Contribution::STATUS_SIGNATURES_OPEN == $contrib->getStatus()) {
                    $em = $this->entityManager;

                    if (is_a($contrib, 'AppBundle\Entity\Congres\GeneralContribution')) {
                        return !$em->getRepository('AppBundle:Congres\GeneralContribution')->hasVoted($user);
                    }

                    return !$contrib->getVotes()->contains($user);
                }
            }

            return false;
        }

        if ($this->container->get('security.context')->isGranted('CALENDAR_contribution_read')) {
            return (Contribution::STATUS_SIGNATURES_CLOSED || in_array('ROLE_ADMIN', $user->getRoles(), true));
        }

        return false;
    }

    public function __construct($entityManager, $container)
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
    }
}
