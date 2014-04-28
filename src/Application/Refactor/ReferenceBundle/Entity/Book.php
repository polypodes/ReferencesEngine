<?php

namespace Application\Refactor\ReferenceBundle\Entity;

//use Doctrine\ORM\Mapping as ORM;

use app\Faker\autoload;
use Faker;

/**
 * Book
 */
class Book
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $clientName;

    /**
     * @var string
     */
    private $projectName;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string $fiches
     */
    protected $fiches;

    /**
     * @var \Datetime created_at
     */
    protected $created_at;

    /**
     * @var \Datetime updated_at
     */
    protected $updated_at;

    /**
     * @var boolean published
     */
    protected $published;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set clientName
     *
     * @param string $clientName
     * @return Book
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;

        return $this;
    }

    /**
     * Get clientName
     *
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * Set projectName
     *
     * @param string $projectName
     * @return Book
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Get projectName
     *
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Book
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get fiches
     *
     * @return Application\Refactor\ReferenceBundle\Entity\FicheFiche
     */
    public function getFiches()
    {
        return $this->fiches;
    }

    /**
     * Set fiches
     *
     * @param Application\Refactor\ReferenceBundle\Entity\FicheFiche $fiches
     */
    public function setFiches($fiches)
    {
        //$this->medias = new ArrayCollection();

        foreach($fiches as $t)
        {
            $t->setFiche($this);
            $this->addFiche($t);
        }

        return $this;
    }

    public function addFiche($fiche)
    {
        $this->fiches[] = $fiche;
        return $this;
    }

    public function removeFiche($fiche)
    {
        return $this->fiches->removeElement($fiche);
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Fiche
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Fiche
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set published
     *
     * @param boolean published
     * @return Fiche
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }




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
        $this->setTitle($faker->sentence($nbWords=6));
        $this->setClientName($faker->name);
        $this->setProjectName($faker->sentence($nbWords=6));
        $this->setDate($faker->dateTime($max = 'now'));
        $this->setUpdatedAt($faker->dateTime($max = 'now'));
        $this->setCreatedAt($faker->dateTime($max = 'now'));
        $this->setPublished(true);
    }
}
