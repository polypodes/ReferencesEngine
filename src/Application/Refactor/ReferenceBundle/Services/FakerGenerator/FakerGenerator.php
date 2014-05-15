<?php
namespace Application\Refactor\ReferenceBundle\Services\FakerGenerator;

use Doctrine\ORM\EntityManager;
use Application\Refactor\ReferenceBundle\Entity\Tag;
use Application\Refactor\ReferenceBundle\Entity\Fiche;
use Application\Refactor\ReferenceBundle\Entity\FicheTag;
// use Application\Sonata\MediaBundle\Entity\Media;
use Application\Refactor\ReferenceBundle\Entity\FicheMedia;
use Application\Refactor\ReferenceBundle\Entity\Book;
use Application\Refactor\ReferenceBundle\Entity\FicheBook;
use Application\Refactor\ReferenceBundle\Entity\FicheRender;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use app\Faker\autoload;
use Faker;


class FakerGenerator extends Controller
{
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
		$this->getFake();
	}
	public function getFake()
	{

		//Create some tags
		$datatag = [];
		$em = $this->em;
		for ($i=0; $i < 10; $i++) {
	        $tag = new Tag();
	        $tag->getFake();
	        $datatag[$i]= $tag;
	        $em->persist($tag);
	        $em->flush();
	    }

	    $datafiche = [];
	    //Create some Fiches
	    for ($i=0; $i < 20; $i++) {
	        $fiche = new Fiche();
	        $fiche->getFake();
	        for ($j=0; $j < rand(1,3); $j++) {
		        $fiche->addTag($datatag[$j]);
		    }
		     for ($j=0; $j < rand(1,1); $j++) {
                 //TODO: insert 2 images first
		        $fiche->addRender($em->getRepository('Application\Sonata\MediaBundle\Entity\Media')->findOneById(2));
		    }
		    for ($j=0; $j < rand(1,1); $j++) {
		        $fiche->addMedia($em->getRepository('Application\Sonata\MediaBundle\Entity\Media')->findOneById(2));
		    }
	        $fiche->setImage($em->getRepository('Application\Sonata\MediaBundle\Entity\Media')->findOneById(1));
	        $datafiche[$i]=$fiche;
	        $em->persist($fiche);
	        $em->flush();
	    }



	    	    //Create some books
	    for ($i=0; $i < 2; $i++) {
	        $book = new Book();
	        $book->getFake();
	        for ($j=0; $j < rand(4,10); $j++) {
		        $book->addFiche($datafiche[$j]);
		    }
	        $em->persist($book);
	        $em->flush();
	    }

        return(true);
	}
}
