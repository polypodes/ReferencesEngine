<?php

namespace Application\Refactor\ReferenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use app\Faker\autoload;
use Faker;

/**
 * Tag
 *
 * @ORM\Table(name="reference__tag")
 * @ORM\Entity
 */
class Tag
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    // Getter, Setters, _Construct, __toString

    public function __toString()
    {
        return $this->getTitle();
    }

        public function __construct()
    {
        $this->created_at = new \DateTime;
        $this->updated_at = $this->created_at;
    }
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
     * @return Tag
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
     * Set slug
     *
     * @param string $slug
     * @return Tag
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Tag
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Tag
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

     // Events

    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime);
        $this->setUpdatedAt($this->createdAt);

        $slug = $this->getSlug();
        if (empty($slug))
        {
            $this->slug = $this->slugify($this->getTitle());
        } else {
            $this->slug = $this->slugify($this->getSlug());
        }
    }

    public function preUpdate()
    {
        $this->updatedAt = new \DateTime;

        $slug = $this->getSlug();
        if (empty($slug))
        {
            $this->slug = $this->slugify($this->getTitle());
        } else {
            $this->slug = $this->slugify($this->getSlug());
        }
    }

    public function slugify($str, $char = '-')
    {
        //$str = strtolower( trim( preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', iconv('UTF-8', 'ASCII//TRANSLIT', $str) ), $char ) );
        //$str = preg_replace("/[\/_|+ -]+/", $char, $str);
        //return $str;
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', $char, html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($str, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), $char));
    }

        public function getFake()
    {
        $faker = Faker\Factory::create();
        $this->setTitle($faker->word);
        $this->setSlug($faker->word);
        $this->setCreatedAt($faker->dateTime($max = 'now'));
        $this->setUpdatedAt($faker->dateTime($max = 'now'));
        return $this;
    }

}