<?php

namespace Application\Refactor\ReferenceBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Application\Refactor\ReferenceBundle\Entity\FicheRender;
use Application\Refactor\ReferenceBundle\Entity\FicheMedia;
use Application\Refactor\ReferenceBundle\Entity\FicheTag;

/**
 * @author <yourname> <youremail>
 */
class Fiche
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $title2
     */
    protected $title2;

    /**
     * @var \Datetime $date
     */
    protected $date;

    /**
     * @var string content
     */
    protected $content;

    /**
     * @var string content
     */
    protected $rawContent;

    /**
     * @var string content
     */
    protected $contentFormatter;

    /**
     * @var string $image
     */
    protected $image;

    /**
     * @var string $image_alt
     */
    protected $image_alt;

    /**
     * @var string $renders
     */
    protected $renders;

    /**
     * @var string $medias
     */
    protected $medias;

    /**
     * @var string $tags
     */
    protected $tags;

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
     * .ctor()
     */
    public function __construct()
    {
        $this->renders = new ArrayCollection();
        $this->medias = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Get id
     *
     * @return integer $id
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
     * @param string $title
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
     * @param \Datetime $date
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
     * @return \Datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Atelier
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

    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;

        return $this;
    }

    /**
     * Get rawContent
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * Set contentFormatter
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;

        return $this;
    }

    /**
     * Get contentFormatter
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * Set image
     *
     * @param Application\Sonata\MediaBundle\Entity\Media $media
     * @return Fiche
     */
    public function setImage($media)
    {
        $this->image = $media;

        return $this;
    }

    /**
     * Get image
     *
     * @return Application\Sonata\MediaBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get renders
     *
     * @return Application\Sonata\MediaBundle\Entity\Media
     */
    public function getRenders()
    {
        return $this->renders;
    }

    /**
     * Set renders
     *
     * @param Application\Sonata\MediaBundle\Entity\Media $media
     */
    public function setRenders($ficheRenders)
    {
        //$this->renders = new ArrayCollection();

        foreach($ficheRenders as $r)
        {
            $r->setFiche($this);
            $this->addRender($r);
        }
    }

    public function addRender($ficheRender)
    {
        $this->renders[] = $ficheRender;
        return $this;
    }

    public function removeRender($ficheRender)
    {
        return $this->renders->removeElement($ficheRender);
    }


    /**
     * Get medias
     *
     * @return Application\Sonata\MediaBundle\Entity\Media
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * Set medias
     *
     * @param Application\Sonata\MediaBundle\Entity\Media $medias
     */
    public function setMedias($ficheMedias)
    {
        //$this->medias = new ArrayCollection();

        foreach($ficheMedias as $m)
        {
            $m->setFiche($this);
            $this->addMedia($m);
        }

        return $this;
    }

    public function addMedia($ficheMedia)
    {
        $this->medias[] = $ficheMedia;
        return $this;
    }

    public function removeMedia($ficheMedia)
    {
        return $this->medias->removeElement($ficheMedia);
    }

    /**
     * Get tags
     *
     * @return Application\Refactor\ReferenceBundle\Entity\FicheTag
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set tags
     *
     * @param Application\Refactor\ReferenceBundle\Entity\FicheTag $tags
     */
    public function setTags($tags)
    {
        //$this->medias = new ArrayCollection();

        foreach($tags as $t)
        {
            $t->setFiche($this);
            $this->addTag($t);
        }

        return $this;
    }

    public function addTag($tag)
    {
        $this->tags[] = $tag;
        return $this;
    }

    public function removeTag($tag)
    {
        return $this->tags->removeElement($tag);
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
  }
