<?php
namespace AppBundle\Security\Congres;

use AppBundle\Entity\Congres\Contribution;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;

final class CalendarVoter extends AbstractVoter
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

    protected function isGranted($attribute, $route, $user = null)
    {
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($attribute === self::VIEW) {
            if (Contribution::STATUS_NEW === $contrib->getStatus()) {
                $em = $this->getEntityManager();
                $access = $em->createQueryBuilder('a')
                    ->from('Access', 'a')
                    ->where('a.route = :route')
                    ->andWhere('a.begin <= :begin')
                    ->andWhere('a.end > :end')
                    ->setParameter('route', $route)
                    ->setParameter('begin', $begin)
                    ->setParameter('end', $end)
                    ->getQuery()->getSingleResult();
                    
                return ($access || in_array('ROLE_ADMIN', $user->getRoles(), true));
            }

            return true;
        }


        return false;
    }
}
