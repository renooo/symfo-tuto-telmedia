<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FooCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:foo')
            ->setDescription('Hello PhpStorm')
            ->addArgument('magic_number', InputArgument::REQUIRED, 'Allez-vous deviner le nombre magique ?');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('ENV : '.$this->getContainer()->getParameter('kernel.environment'));
        $output->writeln('API BandsInTown :');
        $output->writeln($this->getContainer()->getParameter('bandsintown_api_url'));

        if (42 === (int) $input->getArgument('magic_number')) {
            $output->writeln('Bravo vous avez gagné !');
        }
    }
}
