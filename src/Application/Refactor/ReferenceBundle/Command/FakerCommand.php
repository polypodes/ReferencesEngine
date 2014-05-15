<?php
namespace Application\Refactor\ReferenceBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Application\Refactor\ReferenceBundle\Model\Fiche;
use Doctrine\Common\Annotations\AnnotationReader;
// use Application\Refactor\ReferenceBundle\Services\Faker;
// use app\Faker\autoload;
// use Faker;
// require_once 'Faker/src/autoload.php';

class FakerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('generate:faker')
            ->setDescription('Genererate base of test')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if($this->getContainer()->get('myreference.fakergenerator'))
            $text = 'Database updated!';
        else
            $text = 'Oops! An Error Occurred';
        $output->writeln($text);
    }
}