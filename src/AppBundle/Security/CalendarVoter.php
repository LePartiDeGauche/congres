<?php
namespace AppBundle\Security;

use AppBundle\Entity\Congres\Contribution;
use AppBundle\Entity\Access;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;
final class CalendarVoter extends AbstractVoter
{
    const VIEW = 'view';
    private $entityManager;

    protected function getSupportedAttributes()
    {
        return array(self::VIEW);
    }

    protected function getSupportedClasses()
    {
        return array('AppBundle\RouteString');
    }

    protected function isGranted($attribute, $route, $user = null)
    {
        if (!$user instanceof UserInterface) {
            return false;
        }
 
        if ($attribute === self::VIEW) {

            $now = new \DateTime();
            $em = $this->entityManager;
            $access = $em->createQueryBuilder()
                ->select('a')
                ->from('AppBundle:Access', 'a')
                ->where('a.route = :route')
                ->andWhere('a.begin <= :now')
                ->andWhere('a.end > :now')
                ->setParameter('route', $route->getRoute())
                ->setParameter('now', $now)
                ->getQuery()->getOneOrNullResult();

            return ($access || in_array('ROLE_ADMIN', $user->getRoles(), true));
        }
        return false;

    }
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
