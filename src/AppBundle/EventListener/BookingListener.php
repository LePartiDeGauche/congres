<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Event\Booking;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Listener for counting if the total of bookings is more important than the number of places available
 */
class BookingListener
{
    private $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->checkLastAvailablePlace($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->checkLastAvailablePlace($args);
    }

    private function checkLastAvailablePlace(LifecycleEventArgs $args){

        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();


        if ($entity instanceof Booking) {
            $date = $entity->getDate();

            $bookings = $entityManager->getRepository('AppBundle:Event\Booking')
                ->findBy(['date' => $date]);
            $numberOfBookings = count($bookings);

            $bedrooms = $entityManager->getRepository('AppBundle:Event\Bedroom')->findBedroomsActivesByDate($date);

            $numberOfPlaces = 0;
            foreach ($bedrooms as $bedroom) {
               $numberOfPlaces = $numberOfPlaces + ($bedroom->getRoomType()->getPlaces());
            }

            if ($numberOfPlaces <= $numberOfBookings) {

                $message = \Swift_Message::newInstance()
                    ->setSubject('Hébergement : places manquantes !')
                    ->setFrom('postmaster@example.com')
                    ->setTo('mpoprandi@yahoo.fr')
                    ->setBody('Le nombre de places réservées pour le prochain événement est rempli, il faudrait penser à
                    en réserver de nouvelles !')
                ;
                $this->mailer->send($message);
            }
        }
    }
}