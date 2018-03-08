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
        ->setName('app:adherents:update')

        // the short description shown while running "php app/console list"
        ->setDescription('Update adherent information.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to update info about an adherent.')

        // configure an argument
        ->addArgument('emails', InputArgument::IS_ARRAY, 'The e-mail of the adherent.')

        ->addOption('responsability', 'r', InputOption::VALUE_REQUIRED, 'Responsability to set on user.', null)

        ->addOption('delete', 'd', InputOption::VALUE_NONE, 'Remove responsability to those adherents that are not provided.', null)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $mails = $input->getArgument('emails');

        $responsability_name = $input->getOption('responsability');
        if (!isset($responsability_name)) {
            $output->writeln("No responsability name provided. Stopped");
            return;
        }

        $em = $this->getContainer()->get('doctrine')->getManager();
        $responsability = $em->getRepository(Responsability::class)
                                ->findOneByName($responsability_name);

        foreach ($mails as $mail) {
            $adherent = $em->getRepository(Adherent::class)->findOneByEmail($mail);
            if (!$adherent) {
                $output->writeln("Adherent not found: " . $mail);
                break;
            }
            $output->writeln("Adherent found: " . $adherent);
            if ($adherent->hasResponsability($responsability)) {
                $output->writeln("Adherent already has responsability: " . $responsability->getName());
            } else {
                $output->writeln("Setting responsability: " . $responsability->getName());
                $adherentResponsability = new AdherentResponsability();
                $adherentResponsability->setResponsability($responsability);
                $adherent->addResponsability($adherentResponsability);
                $em->persist($adherent);
            }
        }

        if ($input->getOption('delete')) {
            $ars = $em->getRepository(AdherentResponsability::class)->findByResponsability($responsability);

            foreach ($ars as $ar) {
                $adh = $ar->getAdherent();
                if (!in_array($adh->getEmail(), $input->getArgument('emails'), true)) {
                    $output->writeln('Removing responsability to adherent.' . $adh->getEmail());
                    $adh->removeResponsability($ar);
                    $em->remove($ar);
                    $em->persist($adh);
                }
            }
        }

        $em->flush();
    }
}
