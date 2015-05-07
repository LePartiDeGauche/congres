<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserChecker;

class AdherentUserChecker extends UserChecker
{
    public function checkPreAuth(UserInterface $user)
    {
        if ($user instanceof AppBundle\Entity\User) {
            $profile = $user->getProfile();
            if (!$profile  || !(Adherent::STATUS_OK === $profile->getStatus() || Adherent::STATUS_ATTENTE_RENOUVELLEMENT === $profile->getStatus())) {
                $ex = new LockedException('Status does not allow connection');
                $ex->setUser($user);
                throw $ex;
            }

        }
        parent::checkPreAuth($user);
    }

    public function checkPostAuth(UserInterface $user)
    {
        // check anything

        parent::checkPostAuth($user);
    }
}
