<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\Organ\Organ;
use AppBundle\Entity\Organ\OrganType;
use AppBundle\Entity\Election\Election;
use AppBundle\Entity\Election\ElectionGroup;


class ElectionCreateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "app/console")
        ->setName('app:election:create')

        // the short description shown while running "php app/console list"
        ->setDescription('Create an election.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to create an election.')

        // configure an argument
        ->addArgument('organ', InputArgument::REQUIRED, 'Organ of the election.')

        ->addOption('number', 'p', InputOption::VALUE_REQUIRED, 'Number of candidate to elect.', null)

        ->addOption('type', 't', InputOption::VALUE_REQUIRED, 'Election type.', null)

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $organName = $input->getArgument('organ');
        $type = $input->getOption('type');
        $number = (int) $input->getOption('number');

        if (!isset($number)) {
            $output->writeln("Invalid number provided. Stopped");
            return;
        }

        $em = $this->getContainer()->get('doctrine')->getManager();

        $organType = $em->getRepository(OrganType::class)
                                ->findOneByName(OrganType::COORD_DEP_NAME);
        if (!isset($organType)) {
            $output->writeln("Organ type not found. Stopped");
            return;
        }

        $organ = $em->getRepository(Organ::class)
                                ->getOrganByTypeAndDescription($organType, $organName);
        if (!isset($organ[0])) {
            $output->writeln(sprintf("Organ '%s' not found. Stopped", $organName));
            return;
        } else {
            $organ = $organ[0];
        }

        $group = $em->getRepository(ElectionGroup::class)
                                ->findOneByName($type);
        if (!isset($group)) {
            $output->writeln("Election type not found. Stopped");
            return;
        }

        $election = new Election();
        $election->setNumberOfElected($number);
        $election->setOrgan($organ);
        $election->setStatus(Election::STATUS_OPEN);
        $election->setGroup($group);

        $em->persist($election);

        $em->flush();
    }
}
