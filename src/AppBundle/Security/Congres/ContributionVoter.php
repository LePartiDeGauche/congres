<?php
namespace AppBundle\Security\Congres;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ContributionVoter extends AbstractVoter
{
    const VIEW = 'view';

    protected function getSupportedAttributes()
    {
        return array(self::VIEW);
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
            return ($user === $contrib->getAuthor() || in_array('ROLE_ADMIN', $user->getRoles(), true));
        }

        return false;
    }
}
