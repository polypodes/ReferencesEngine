<?php

namespace Application\Refactor\ReferenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

use Faker;

/**
 * Book
 *
 * @ORM\Table(name="reference__book")
 * @ORM\Entity
 *
 * @ExclusionPolicy("all")
 *
 */
class Book
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     * @Groups({"Book"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Expose
     * @Groups({"Book"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="client_name", type="string", length=255, nullable=false)
     * @Expose
     * @Groups({"Book"})
     */
    private $clientName;

    /**
     * @var string
     *
     * @ORM\Column(name="project_name", type="string", length=255, nullable=false)
     * @Expose
     * @Groups({"Book"})
     */
    private $projectName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     * @Expose
     * @Groups({"Book"})
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Expose
     * @Groups({"Book"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Expose
     * @Groups({"Book"})
     */
    private $updatedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean", nullable=false)
     * @Expose
     * @Groups({"Book"})
     */
    private $published;

    /**
     * @ORM\ManyToMany(targetEntity="Application\Refactor\ReferenceBundle\Entity\Fiche", cascade={"persist"})
     * @ORM\JoinTable(name="reference__fiche_book")
     * @Expose
     * @Groups({"Fiche"})
     */
    private $fiches;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;

    }//end getId()

    /**
     * Set title
     *
     * @param  string $title
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;

    }//end setTitle()

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;

    }//end getTitle()

    /**
     * Set clientName
     *
     * @param  string $clientName
     * @return Book
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;

        return $this;

    }//end setClientName()

    /**
     * Get clientName
     *
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;

    }//end getClientName()

    /**
     * Set projectName
     *
     * @param  string $projectName
     * @return Book
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;

        return $this;

    }//end setProjectName()

    /**
     * Get projectName
     *
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;

    }//end getProjectName()

    /**
     * Set date
     *
     * @param  \DateTime $date
     * @return Book
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;

    }//end setDate()

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;

    }//end getDate()

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Book
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;

    }//end setCreatedAt()

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;

    }//end getCreatedAt()

    /**
     * Set updatedAt
     *
     * @param  \DateTime $updatedAt
     * @return Book
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;

    }//end setUpdatedAt()

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;

    }//end getUpdatedAt()

    /**
     * Set published
     *
     * @param  boolean $published
     * @return Book
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;

    }//end setPublished()

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;

    }//end getPublished()

    public function prePersist()
    {
        $this->createdAt = new \DateTime;
        $this->updatedAt = $this->createdAt;

    }//end prePersist()

    public function preUpdate()
    {
        $this->updatedAt = new \DateTime;

    }//end preUpdate()

    public function getFake()
    {
        $faker = Faker\Factory::create();
        $this->setTitle($faker->sentence($nbWords = 6));
        $this->setClientName($faker->name);
        $this->setProjectName($faker->url()));s
        $this->setDate($faker->dateTime($max            = 'now'));
        $this->setUpdatedAt($faker->dateTime($max       = 'now'));
        $this->setCreatedAt($faker->dateTime($max       = 'now'));
        $this->setPublished(true);

    }//end getFake()

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fiches = new \Doctrine\Common\Collections\ArrayCollection();

    }//end __construct()

    /**
     * Add fiches
     *
     * @param  \Application\Refactor\ReferenceBundle\Entity\Fiche $fiches
     * @return Book
     */
    public function addFiche(\Application\Refactor\ReferenceBundle\Entity\Fiche $fiches)
    {
        $this->fiches[] = $fiches;

        return $this;

    }//end addFiche()

    /**
     * Remove fiches
     *
     * @param \Application\Refactor\ReferenceBundle\Entity\Fiche $fiches
     */
    public function removeFiche(\Application\Refactor\ReferenceBundle\Entity\Fiche $fiches)
    {
        $this->fiches->removeElement($fiches);

    }//end removeFiche()

    /**
     * Get fiches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiches()
    {
        return $this->fiches;

    }//end getFiches()
}//end class
