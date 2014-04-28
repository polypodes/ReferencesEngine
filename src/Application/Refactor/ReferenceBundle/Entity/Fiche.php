<?php

namespace Application\Refactor\ReferenceBundle\Entity;
use Application\Refactor\ReferenceBundle\Model\Fiche as FicheModel;

use app\Faker\autoload;
use Faker;


/**
 * @author <yourname> <youremail>
 */
class Fiche extends FicheModel
{
    public function prePersist()
    {
        $this->created_at = new \DateTime;
        $this->updated_at = $this->created_at;
    }

    public function preUpdate()
    {
        $this->updated_at = new \DateTime;
    }

    public function getFake()
    {
        $faker = Faker\Factory::create();
        $this->setTitle($faker->sentence($nbWords = 3));
        $this->setTitle2($faker->sentence($nbWords = 6));
        $this->setDate($faker->dateTime($max = 'now') );
        $this->setContent($faker->text);
        $this->setRawContent($faker->text);
        $this->setContentFormatter('null');
        // $this->setImage($faker->imageUrl($width = 640, $height = 480));
        $this->setPublished(true);
    }

}
