<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\Organ\Organ;
use AppBundle\Entity\Organ\OrganType;


class CleanupOrgansCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "app/console")
        ->setName('app:cleanup:organs')

        // the short description shown while running "php app/console list"
        ->setDescription('Cleanup organs data inside database.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to cleanup organs data inside database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $coordOrganType = $em->getRepository(OrganType::class)->findOneByName(OrganType::COORD_DEP_NAME);
        $output->writeln("Found organ #" . $coordOrganType->getId());
        $organs = $em->getRepository(Organ::class)->findAll();
        foreach ($organs as $organ) {
            if ($organ->getOrganType()->getName() == OrganType::COORD_DEP_NAME &&
                $organ->getOrganType() != $coordOrganType) {
                $output->writeln("Changing type for:" . $organ->getName());
                $organ->setOrganType($coordOrganType);
                $em->persist($organ);
            }
        }
        $em->flush();

        $output->write("Removing old organ types:");
        $organTypes = $em->getRepository(OrganType::class)->findByName(OrganType::COORD_DEP_NAME);
        foreach ($organTypes as $organType) {
            if ($organType != $coordOrganType) {
                $output->write($organType->getId() . ', ');
                $em->remove($organType);
            }
        }
        $output->writeln("Done.");
        $em->flush();

        $comiteOrganType = $em->getRepository(OrganType::class)->findOneByName(OrganType::COMITE_NAME);
        $output->writeln("Found organ #" . $comiteOrganType->getId());
        $organs = $em->getRepository(Organ::class)->findAll();
        foreach ($organs as $organ) {
            if ($organ->getOrganType()->getName() == OrganType::COMITE_NAME &&
                    $organ->getOrganType() != $comiteOrganType) {
                $output->writeln("Changing type for:" . $organ->getName());
                $organ->setOrganType($comiteOrganType);
                $em->persist($organ);
            }
        }
        $em->flush();

        $output->write("Removing old organ types:");
        $organTypes = $em->getRepository(OrganType::class)->findByName(OrganType::COMITE_NAME);
        foreach ($organTypes as $organType) {
            if ($organType != $comiteOrganType) {
                $output->write($organType->getId() . ', ');
                $em->remove($organType);
            }
        }
        $output->writeln("Done.");
        $em->flush();
    }
}
