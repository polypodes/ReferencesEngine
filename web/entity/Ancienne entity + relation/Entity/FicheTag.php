<?php

namespace Application\Refactor\ReferenceBundle\Entity;

//use Doctrine\Common\Collections\ArrayCollection;


class FicheTag
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
     * @var Application\Refactor\ReferenceBundle\Entity\Tag $tag
     * */
    protected $tag;

    /**
     * @var integer $order
     */
    protected $order = 0;


    // Getter, Setters, _Construct, __toString

    public function __toString()
    {
        return $this->getTag()->getTitle();
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
     * Set fiche
     *
     * @param Fiche $fiche
     * @return FicheTag
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
     * Set tag
     *
     * @param Application\Refactor\ReferenceBundle\Entity\FicheTag $tag
     * @return FicheTag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return Application\Refactor\ReferenceBundle\Entity\Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return FicheTag
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
