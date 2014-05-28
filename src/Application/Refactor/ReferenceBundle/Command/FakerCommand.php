<?php
namespace Application\Refactor\ReferenceBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('generate:faker')// set the commande tool
            ->setDescription('Genererate base of test') //set description
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->getContainer()->get('myreference.fakergenerator'))
        {
            $text = 'Database updated!'; //if command worked
        } else {
            $text = 'Oops! An Error Occurred'; //if not
        }
        $output->writeln($text); //output
    }
}