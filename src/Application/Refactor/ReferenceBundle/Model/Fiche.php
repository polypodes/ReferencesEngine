<?php

namespace Application\Refactor\ReferenceBundle\Model;

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
     * @var text $description
     */
    protected $description;

    /**
     * @var string $image_url
     */
    protected $image_url;

    /**
     * @var string $image_alt
     */
    protected $image_alt;

    /**
     * @var \Datetime created_at
     */
    protected $created_at;

    /**
     * @var \Datetime updated_at
     */
    protected $updated_at;


    /**
     * .ctor()
     */
    public function __construct()
    {

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
     * Set description
     *
     * @param text $description
     * @return Fiche
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image_url
     *
     * @param string $url
     * @return Fiche
     */
    public function setImageUrl($url)
    {
        $this->image_url = $url;

        return $this;
    }

    /**
     * Get image_url
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * Set image_alt
     *
     * @param string $description
     * @return Fiche
     */
    public function setImageAlt($alt)
    {
        $this->image_alt = $alt;

        return $this;
    }

    /**
     * Get image_alt
     *
     * @return string
     */
    public function getImageAlt()
    {
        return $this->image_alt;
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

  }
