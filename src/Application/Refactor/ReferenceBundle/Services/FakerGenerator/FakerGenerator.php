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

use app\Faker\autoload;
use Faker;


class FakerGenerator
{
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
		$this->getFake();
	}
	public function getFake()
	{
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
	    for ($i=0; $i < 20; $i++) { 
	        $fiche = new Fiche();
	        $fichemedia = new FicheMedia();
	        $fiche->getFake();
	        for ($j=0; $j < rand(1,3); $j++) { 
		        $fichetag = new FicheTag();
		        $fichetag->setFiche($fiche);
		        $fichetag->setTag($datatag[rand(0,9)]);
		        $em->persist($fichetag);
		    }
	        $fichemedia->setFiche($fiche);
	        $fichemedia->setMedia($em->getRepository('Application\Sonata\MediaBundle\Entity\Media')->findOneById(1));
	        $datafiche[$i]=$fiche;
	        $em->persist($fiche);
	        $em->persist($fichemedia);
	        $em->flush();
	    }
	    for ($i=0; $i < 2; $i++) { 
	        $book = new Book();
	        $book->getFake();
	        for ($j=0; $j < rand(2, 4); $j++) { 
		        $fichebook = new FicheBook();
		        $fichebook->setBook($book);
		        $fichebook->setFiche($datafiche[rand(0,19)]);
		        $em->persist($fichebook);
		    }
	        $em->persist($book);
	        $em->flush();
	    }

        return(true);
	}
}