<?php
namespace AppBundle\Security\Congres;

use AppBundle\Entity\Congres\Contribution;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ContributionVoter extends AbstractVoter
{
    const VIEW = 'view';

    const DELETE = 'delete';

    protected function getSupportedAttributes()
    {
        return array(self::VIEW, self::DELETE);
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

        return false;
    }
}
