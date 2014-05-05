<?php

namespace Application\Refactor\ReferenceBundle\Entity;

//use Doctrine\Common\Collections\ArrayCollection;


/**
 *
 */
class FicheMedia
{

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var Fiche $fiche
     * */
    protected $fiche;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media $media
     * */
    protected $media;

    /**
     * @var integer $order
     */
    protected $order = 0;


    // Getter, Setters, _Construct, __toString

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
     * Set fiche
     *
     * @param Fiche $fiche
     * @return FicheRender
     */
    public function setFiche($fiche)
    {
        $this->fiche = $fiche;

        return $this;
    }

    /**
     * Get fiche
     *
     * @return Fiche
     */
    public function getFiche()
    {
        return $this->fiche;
    }

    /**
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     * @return FicheRender
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return FicheRender
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

}
