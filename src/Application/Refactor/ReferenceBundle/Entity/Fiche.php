<?php

namespace Application\Refactor\ReferenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use app\Faker\autoload;
use Faker;

/**
 * Fiche
 *
 * @ORM\Table(name="reference__fiche")
 * @ORM\Entity
 */
class Fiche
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
     * @ORM\Column(name="title2", type="string", length=255, nullable=true)
     */
    private $title2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="raw_content", type="text", nullable=true)
     */
    private $rawContent;

    /**
     * @var string
     *
     * @ORM\Column(name="content_formatter", type="string", length=255, nullable=true)
     */
    private $contentFormatter;

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

    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean", nullable=false)
     */
    private $published;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * })
     */
    private $image;

    /**
    * @ORM\ManyToMany(targetEntity="Application\Refactor\ReferenceBundle\Entity\Tag", cascade={"persist"})
    * @ORM\JoinTable(name="reference__fiche_tag")
    */
    private $tags;
     /**
    * @ORM\ManyToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
    * @ORM\JoinTable(name="reference__fiche_render")
    */
    private $renders;
     /**
    * @ORM\ManyToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
    * @ORM\JoinTable(name="reference__fiche_media")
    */
    private $medias;









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
     * @return Fiche
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
     * Set title2
     *
     * @param string $title2
     * @return Fiche
     */
    public function setTitle2($title2)
    {
        $this->title2 = $title2;

        return $this;
    }

    /**
     * Get title2
     *
     * @return string
     */
    public function getTitle2()
    {
        return $this->title2;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Fiche
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
     * Set content
     *
     * @param string $content
     * @return Fiche
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set rawContent
     *
     * @param string $rawContent
     * @return Fiche
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;

        return $this;
    }

    /**
     * Get rawContent
     *
     * @return string
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * Set contentFormatter
     *
     * @param string $contentFormatter
     * @return Fiche
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;

        return $this;
    }

    /**
     * Get contentFormatter
     *
     * @return string
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Fiche
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
     * @return Fiche
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

    /**
     * Set published
     *
     * @param boolean $published
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

    /**
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     * @return Fiche
     */
    public function setImage(\Application\Sonata\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \DateTime;
    }

    /**
     * Add tags
     *
     * @param \Application\Refactor\ReferenceBundle\Entity\Tag $tags
     * @return Fiche
     */
    public function addTag(\Application\Refactor\ReferenceBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Application\Refactor\ReferenceBundle\Entity\Tag $tags
     */
    public function removeTag(\Application\Refactor\ReferenceBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add renders
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $renders
     * @return Fiche
     */
    public function addRender(\Application\Sonata\MediaBundle\Entity\Media $renders)
    {
        $this->renders[] = $renders;

        return $this;
    }

    /**
     * Remove renders
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $renders
     */
    public function removeRender(\Application\Sonata\MediaBundle\Entity\Media $renders)
    {
        $this->renders->removeElement($renders);
    }

    /**
     * Get renders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRenders()
    {
        return $this->renders;
    }

    /**
     * Add medias
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $medias
     * @return Fiche
     */
    public function addMedia(\Application\Sonata\MediaBundle\Entity\Media $medias)
    {
        $this->medias[] = $medias;

        return $this;
    }

    /**
     * Remove medias
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $medias
     */
    public function removeMedia(\Application\Sonata\MediaBundle\Entity\Media $medias)
    {
        $this->medias->removeElement($medias);
    }

    /**
     * Get medias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedias()
    {
        return $this->medias;
    }

    public function prePersist()
    {
        $this->createdAt = new \DateTime;
        $this->updatedAt = $this->createdAt;
    }

    public function preUpdate()
    {
        $this->updatedAt = new \DateTime;
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
        $this->setPublished(true);
        $this->prePersist();
        $this->setCreatedAt($faker->dateTime($max = 'now') );
    }

}