<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\AdherentResponsability;
use AppBundle\Entity\Adherent;
use AppBundle\Entity\Responsability;


class UpdateAdherentCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "app/console")
        ->setName('app:update-adherent')

        // the short description shown while running "php app/console list"
        ->setDescription('Update adherent information.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to update info about an adherent.')

        // configure an argument
        ->addArgument('email', InputArgument::REQUIRED, 'The e-mail of the adherent.')

        ->addOption('responsability', 'r', InputOption::VALUE_REQUIRED, 'Responsability to set on user.', null)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $mail = $input->getArgument('email');
        $em = $this->getContainer()->get('doctrine')->getManager();

        $adherent = $em->getRepository(Adherent::class)->findOneByEmail($mail);

        if (!$adherent) {
            $output->writeln("Adherent not found: " . $email);
            return;
        }
        $output->writeln("Adherent found: " . $adherent);

        $responsability_name = $input->getOption('responsability');
        if (!isset($responsability_name)) {
            $output->writeln("No responsability name provided. Stopped");
            return;
        }

        $cn_responsability = $em->getRepository(Responsability::class)
                                ->findOneByName($responsability_name);
        if ($adherent->hasResponsability($cn_responsability)) {
            $output->writeln("Adherent already has responsability: " . $cn_responsability);
        } else {
            $output->writeln("Setting responsability: " . $cn_responsability);
            $adherentResponsability = new AdherentResponsability();
            $adherentResponsability->setResponsability($cn_responsability);
            $adherent->addResponsability($adherentResponsability);
        }

        $em->persist($adherent);
        $em->flush();
    }
}
