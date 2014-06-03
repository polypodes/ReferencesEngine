<?php

namespace Application\Refactor\ReferenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

use Faker;

/**
 * Fiche
 *
 * @ORM\Table(name="reference__fiche")
 * @ORM\Entity
 *
 * @ExclusionPolicy("all")
 *
 */
class Fiche
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     * @Groups({"Fiche"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Expose
     * @Groups({"Fiche"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="title2", type="string", length=255, nullable=true)
     * @Expose
     * @Groups({"Fiche"})
     */
    private $title2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     * @Expose
     * @Groups({"Fiche"})
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     * @Expose
     * @Groups({"Fiche"})
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="raw_content", type="text", nullable=true)
     * @Expose
     * @Groups({"Fiche"})
     */
    private $rawContent;

    /**
     * @var string
     *
     * @ORM\Column(name="content_formatter", type="string", length=255, nullable=true)
     * @Expose
     * @Groups({"Fiche"})
     */
    private $contentFormatter;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Expose
     * @Groups({"Fiche"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Expose
     * @Groups({"Fiche"})
     */
    private $updatedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean", nullable=false)
     * @Expose
     * @Groups({"Fiche"})
     */
    private $published;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * })
     * @Groups({"sonata_api_read"})
     * @Expose
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="Application\Refactor\ReferenceBundle\Entity\Tag", cascade={"persist"})
     * @ORM\JoinTable(name="reference__fiche_tag")
     * @Groups({"Fiche"})
     * @Expose
     */
    private $tags;

     /**
      * @ORM\ManyToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
      * @ORM\JoinTable(name="reference__fiche_render")
      * @Groups({"sonata_api_read"})
      * @Expose
      */
    private $renders;

     /**
      * @ORM\ManyToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"})
      * @ORM\JoinTable(name="reference__fiche_media")
      * @Groups({"sonata_api_read"})
      * @Expose
      */
    private $medias;

    public function __toString()
    {
        return $this->getTitle();

    }//end __toString()

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
     * @return Fiche
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
     * Set title2
     *
     * @param  string $title2
     * @return Fiche
     */
    public function setTitle2($title2)
    {
        $this->title2 = $title2;

        return $this;

    }//end setTitle2()

    /**
     * Get title2
     *
     * @return string
     */
    public function getTitle2()
    {
        return $this->title2;

    }//end getTitle2()

    /**
     * Set date
     *
     * @param  \DateTime $date
     * @return Fiche
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
     * Set content
     *
     * @param  string $content
     * @return Fiche
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;

    }//end setContent()

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;

    }//end getContent()

    /**
     * Set rawContent
     *
     * @param  string $rawContent
     * @return Fiche
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;

        return $this;

    }//end setRawContent()

    /**
     * Get rawContent
     *
     * @return string
     */
    public function getRawContent()
    {
        return $this->rawContent;

    }//end getRawContent()

    /**
     * Set contentFormatter
     *
     * @param  string $contentFormatter
     * @return Fiche
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;

        return $this;

    }//end setContentFormatter()

    /**
     * Get contentFormatter
     *
     * @return string
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;

    }//end getContentFormatter()

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Fiche
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
     * @return Fiche
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
     * @return Fiche
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

    /**
     * Set image
     *
     * @param  \Application\Sonata\MediaBundle\Entity\Media $image
     * @return Fiche
     */
    public function setImage(\Application\Sonata\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;

        return $this;

    }//end setImage()

    /**
     * Get image
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;

    }//end getImage()

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \DateTime;

    }//end __construct()

    /**
     * Add tags
     *
     * @param  \Application\Refactor\ReferenceBundle\Entity\Tag $tags
     * @return Fiche
     */
    public function addTag(\Application\Refactor\ReferenceBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;

    }//end addTag()

    /**
     * Remove tags
     *
     * @param \Application\Refactor\ReferenceBundle\Entity\Tag $tags
     */
    public function removeTag(\Application\Refactor\ReferenceBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);

    }//end removeTag()

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;

    }//end getTags()

    /**
     * Add renders
     *
     * @param  \Application\Sonata\MediaBundle\Entity\Media $renders
     * @return Fiche
     */
    public function addRender(\Application\Sonata\MediaBundle\Entity\Media $renders)
    {
        $this->renders[] = $renders;

        return $this;

    }//end addRender()

    /**
     * Remove renders
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $renders
     */
    public function removeRender(\Application\Sonata\MediaBundle\Entity\Media $renders)
    {
        $this->renders->removeElement($renders);

    }//end removeRender()

    /**
     * Get renders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRenders()
    {
        return $this->renders;

    }//end getRenders()

    /**
     * Add medias
     *
     * @param  \Application\Sonata\MediaBundle\Entity\Media $medias
     * @return Fiche
     */
    public function addMedia(\Application\Sonata\MediaBundle\Entity\Media $medias)
    {
        $this->medias[] = $medias;

        return $this;

    }//end addMedia()

    /**
     * Remove medias
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $medias
     */
    public function removeMedia(\Application\Sonata\MediaBundle\Entity\Media $medias)
    {
        $this->medias->removeElement($medias);

    }//end removeMedia()

    /**
     * Get medias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedias()
    {
        return $this->medias;

    }//end getMedias()

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
        $this->setTitle($faker->sentence($nbWords  = 3));
        $this->setTitle2($faker->sentence($nbWords = 6));
        $this->setDate($faker->dateTime($max       = 'now') );
        $this->setContent($faker->text);
        $this->setRawContent($faker->text);
        $this->setContentFormatter('null');
        $this->setPublished(true);
        $this->prePersist();
        $this->setCreatedAt($faker->dateTime($max = 'now') );

    }//end getFake()
}//end class
