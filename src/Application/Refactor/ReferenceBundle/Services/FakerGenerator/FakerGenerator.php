<?php
namespace Application\Refactor\ReferenceBundle\Services\FakerGenerator;

use Doctrine\ORM\EntityManager;
use Application\Refactor\ReferenceBundle\Entity\Tag;
use Application\Refactor\ReferenceBundle\Entity\Fiche;
use Application\Sonata\MediaBundle\Entity\Media;
use Application\Refactor\ReferenceBundle\Entity\Book;
use Sonata\MediaBundle\Entity\MediaManager;

use app\Faker\autoload;
use Faker;


class FakerGenerator
{
	public function __construct(EntityManager $em, MediaManager $MediaManager, $kernel)
	{
		//Get Service i need to persist
		$this->em = $em;
		$this->MediaManager=$MediaManager;// to save Media
		$this->kernel = $kernel; //to get the root Dir
		$this->getFake();//to generate the DB
	}
	/*
	 * GetRandomUniqueInt($min, $max, $countmin, $countmax)
	 * $min, $max, $countmin, $countmax int
	 * $min/$max : extrem of the values used
	 * $countmin/countmax : extrem of the values needed
	 * return an array with unique int
	 */

	public function getRandomUniqueInt($min, $max, $countmin, $countmax)
	{
		$data_uniqueInt= [];

		if($max < $countmax){
			return null;
		}
		if ($max < $min) {
			$tmp = $min;
			$min= $max;
			$max= $tmp; 
		}
		if ($countmax < $countmin) {
			$tmp = $countmin;
			$countmin= $countmax;
			$countmax= $tmp; 
		}
		for ($i=1; $i <= rand($countmin, $countmax); $i++) { 
			$nb = rand($min, $max);
			if(in_array($nb, $data_uniqueInt))
			{
				$i--;
			}else{
				$data_uniqueInt[]=$nb;
			}
		}
		return $data_uniqueInt;
	}
	/*
	 *GetFake()
	 *Generate Fake Values
	 */
	public function getFake()
	{
		//Set services as var

		$MediaManager = $this->MediaManager;
		$kernel= $this->kernel;
		$em = $this->em;

		//check if dir exist
		
		$dir = $kernel->getRootDir()."/../web/tmp/";//route to save the fake binary content
		if (file_exists($dir)) {
		    echo "Le fichier existe.";
		} else {
		    echo "Le fichier n'existe pas.";
		}

		//Call Faker generator

		$faker = Faker\Factory::create();

		//Set some var with your affinity

		$nbMediaGenerated = 20;

		$nbTagGenerated = 10;
		$nbFicheGenerated = 20;

		$nbMinTagByFicheSet = 1;
		$nbMaxTagByFicheSet = 5;

		$nbMinRenderByFicheSet = 2;
		$nbMaxRenderByFicheSet = 5;

		$nbMinMediaByFicheSet = 2;
		$nbMaxMediaByFicheSet = 5;

		$nbBookGenerated = 4;

		$nbMinFicheByBookSet = 4;
		$nbMaxFicheByBookSet = 10;

		// Create some Medias, only image, to add videos you neeed change the provider and set the BinaryContent to your url (ex:youtube) 
		$datamedia=[];
        for ($i=0; $i < $nbMediaGenerated; $i++) {
	        $media = new Media;
	        $image=$faker->image($dir, '1280','960');// get BinaryContent, $image is the url of the file downloaded
	        //save Media
	        $media->setBinaryContent($image);
	        $media->setName($faker->city());
	        $media->setContext('default'); 
            $media->setProviderName('sonata.media.provider.image');
	        $MediaManager->save($media);
	        $datamedia[$i]=$media;
	    }

		//Create some tags

		$datatag = [];
		for ($i=0; $i < $nbTagGenerated; $i++) {
	        $tag = new Tag();
	        $tag->getFake();
	        $datatag[$i]= $tag;
	        $em->persist($tag);
	        $em->flush();
	    }

	    //Create some Fiches

	    $datafiche = [];

	    for ($i=0; $i < $nbFicheGenerated; $i++) 
	    {
	        $fiche = new Fiche();
	        $fiche->getFake(); //get a faked Fiche

	        $data_uniqueTagsArray=$this->getRandomUniqueInt('0', $nbTagGenerated-1, $nbMinTagByFicheSet, $nbMaxTagByFicheSet); //get unique array of int for tags
	        foreach ($data_uniqueTagsArray as $uniqueTag =>$value) 
	        {
	        	$fiche->addTag($datatag[$value]);//set tags
	        }

	        $data_uniqueRendersArray=$this->getRandomUniqueInt('0', $nbMediaGenerated-1, $nbMinRenderByFicheSet, $nbMaxRenderByFicheSet);
	        foreach ($data_uniqueRendersArray as $uniqueRender =>$value) 
	        {
	        	$fiche->addRender($datamedia[$value]);//set renders
	        }

	        $data_uniqueMediasArray=$this->getRandomUniqueInt('0', $nbMediaGenerated-1, $nbMinMediaByFicheSet, $nbMaxMediaByFicheSet);
	        foreach ($data_uniqueMediasArray as $uniqueMedia =>$value) 
	        {
	        	$fiche->addMedia($datamedia[$value]);//set medias
	        }

	        $fiche->setImage($datamedia[(rand(0, $nbMediaGenerated-1))]);//set main images
	        $datafiche[]=$fiche;
	        $em->persist($fiche);
	        $em->flush();
	    }



	   	//Create some books
	    for ($i=0; $i < $nbBookGenerated; $i++) {
	        $book = new Book();
	        $book->getFake();//get a faked Book

	        $data_uniqueFichesArray=$this->getRandomUniqueInt('0', $nbFicheGenerated-1, $nbMinFicheByBookSet, $nbMaxFicheByBookSet);
	        foreach ($data_uniqueFichesArray as $uniqueFiche =>$value) 
	        {
	        	$book->addFiche($datafiche[$value]);//set fiches
	        }
	        $em->persist($book);
	        $em->flush();
	    }

	    //Delete image downloaded

	    $files = glob($dir.'*'); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
		    unlink($file); // delete file
		}

        return(true);
	}
}
