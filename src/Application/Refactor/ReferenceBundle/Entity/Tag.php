<?php

namespace Application\Refactor\ReferenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Faker;

/**
 * Tag
 *
 * @ORM\Table(name="reference__tag")
 * @ORM\Entity(repositoryClass="Application\Refactor\ReferenceBundle\Repository\TagRepository")
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

    }//end __toString()

    public function __construct()
    {
        $this->createdAt = new \DateTime;
        $this->updatedAt = $this->createdAt;

    }//end __construct()

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
     * @return Tag
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
     * Set slug
     *
     * @param  string $slug
     * @return Tag
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;

    }//end setSlug()

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;

    }//end getSlug()

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Tag
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
     * @return Tag
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

    // Events

    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime);
        $this->setUpdatedAt($this->createdAt);

        $slug = $this->getSlug();
        if (empty($slug)) {
            $this->slug = $this->slugify($this->getTitle());
        } else {
            $this->slug = $this->slugify($this->getSlug());
        }

    }//end prePersist()

    public function preUpdate()
    {
        $this->updatedAt = new \DateTime;

        $slug = $this->getSlug();
        if (empty($slug)) {
            $this->slug = $this->slugify($this->getTitle());
        } else {
            $this->slug = $this->slugify($this->getSlug());
        }

    }//end preUpdate()

    public function slugify($str, $char = '-')
    {
        //$str = strtolower( trim( preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', iconv('UTF-8', 'ASCII//TRANSLIT', $str) ), $char ) );
        //$str = preg_replace("/[\/_|+ -]+/", $char, $str);
        //return $str;
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', $char, html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($str, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), $char));

    }//end slugify()

    public function getFake()
    {
        $faker = Faker\Factory::create();
        $this->setTitle($faker->word);
        $this->setSlug($faker->word);
        $this->setCreatedAt($faker->dateTime($max = 'now'));
        $this->setUpdatedAt($faker->dateTime($max = 'now'));

        return $this;

    }//end getFake()
}//end class
