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
            ->setName('generate:faker:project')
            ->setDescription('Genererate projects')
            // ->addArgument(
            //     'number',
            //     InputArgument::OPTIONAL,
            //     'How much?'
            // )
            // ->addOption(
            //    '',
            //    null,
            //    InputOption::VALUE_NONE,
            //    ''
            // )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $text = 
        if($this->getContainer()->get('myreference.fakergenerator'))
            $text = 'Database updated!';
        else
            $text = 'Oops! An Error Occurred';
        $output->writeln($text);
    }
}