<?php

namespace Application\Refactor\ReferenceBundle\Entity;

//use Doctrine\Common\Collections\ArrayCollection;


class Tag
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
     * @var string $slug
     */
    protected $slug;

    /**
     * @var \Datetime created_at
     */
    protected $created_at;

    /**
     * @var \Datetime updated_at
     */
    protected $updated_at;



    // Getter, Setters, _Construct, __toString

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
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Tag
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
     * @return Tag
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

    // Events

    public function prePersist()
    {
        $this->created_at = new \DateTime;
        $this->updated_at = $this->created_at;

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
        $this->updated_at = new \DateTime;

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
}
