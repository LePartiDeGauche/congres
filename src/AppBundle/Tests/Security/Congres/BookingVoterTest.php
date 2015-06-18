<?php

class BookingVoterTest extends \PHPUnit_Framework_TestCase
{
    public function testVoteAccessAbstain()
    {
        /** @var \Prophecy\Prophecy\ObjectProphecy|\Doctrine\ORM\EntityManager $entityManagerMock */
        $entityManagerMock = $this->prophesize('Doctrine\ORM\EntityManager');

        $tokenMock = $this->prophesize('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $object = new \AppBundle\Entity\Event\Booking();

        $voter = new \AppBundle\Security\Congres\BookingVoter($entityManagerMock->reveal());

        $this->assertEquals(0, $voter->vote($tokenMock->reveal(), $object, []));
    }

    public function testVoteSameDate()
    {
        /** @var \Prophecy\Prophecy\ObjectProphecy|\Doctrine\ORM\EntityManager $entityManagerMock */
        $entityManagerMock = $this->prophesize('Doctrine\ORM\EntityManager');
        /** @var \Prophecy\Prophecy\ObjectProphecy|\Doctrine\ORM\EntityManager $repositoryMock */
        $repositoryMock = $this->prophesize('Doctrine\ORM\EntityRepository');
        $entityManagerMock->getRepository('AppBundle:Event\Booking')->willReturn($repositoryMock->reveal())->shouldBeCalledTimes(0);

        $tokenMock = $this->prophesize('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $object = new \AppBundle\Entity\Event\Booking();
        $object->setBedroom(new \AppBundle\Entity\Event\Bedroom());

        $voter = new \AppBundle\Security\Congres\BookingVoter($entityManagerMock->reveal());

        $this->assertEquals(1, $voter->vote($tokenMock->reveal(), $object, ['SLEEPING_REPORT']));
    }
}
