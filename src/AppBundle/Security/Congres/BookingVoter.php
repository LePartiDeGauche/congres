<?php

namespace AppBundle\Security\Congres;

use AppBundle\Entity\Event\Booking;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class BookingVoter implements VoterInterface
{
    const SLEEPING_REPORT = 'SLEEPING_REPORT';
    const SLEEPING_CLASS = 'AppBundle\Entity\Event\Booking';

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return self::SLEEPING_REPORT === $attribute;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return self::SLEEPING_CLASS === $class;
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        /** @var Booking $object */
        if (!$this->supportsClass(get_class($object)) || !isset($attributes[0]) || !$this->supportsAttribute($attributes[0])) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $bedroom = $object->getBedroom();
        $adherent = $object->getAdherent();
        $date = $object->getDate();

        // Si je suis déjà inscrit à la même date
        $booking = $this->entityManager->getRepository('AppBundle:Event\Booking')->findOneBy(['adherent' => $adherent, 'date' => $date]);
        if ($booking) {
            return VoterInterface::ACCESS_DENIED;
        }

        // Si la chambre est pleine
        $bookingsByBedroom = $this->entityManager->getRepository('AppBundle:Event\Booking')->findBy(['bedroom' => $bedroom, 'date' => $date]);
        $places = $bedroom->getRoomType()->getPlaces();
        if (count($bookingsByBedroom) >= $places) {
            return VoterInterface::ACCESS_DENIED;
        }

        //Si la chambre n'est pas dispo à cette date
        $dateStartAvailability = $bedroom->getDateStartAvailability();
        $dateStopAvailability = $bedroom->getDateStopAvailability();
        if ($date < $dateStartAvailability || $date > $dateStopAvailability) {
            return VoterInterface::ACCESS_DENIED;
        }

        return VoterInterface::ACCESS_GRANTED;
    }
}
