<?php

namespace Application\Refactor\ReferenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FicheTag
 *
 * @ORM\Table(name="reference__fiche_tag")
 * @ORM\Entity
 */
class FicheTag
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
     * @var integer
     *
     * @ORM\Column(name="order", type="integer", nullable=false)
     */
    private $order;

    /**
     * @var \Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * })
     */
    private $tag;

    /**
     * @var \Fiche
     *
     * @ORM\ManyToOne(targetEntity="Fiche")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fiche_id", referencedColumnName="id")
     * })
     */
    private $fiche;



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

    /**
     * Set tag
     *
     * @param \Application\Refactor\ReferenceBundle\Entity\Tag $tag
     * @return FicheTag
     */
    public function setTag(\Application\Refactor\ReferenceBundle\Entity\Tag $tag = null)
    {
        $this->tag = $tag;
    
        return $this;
    }

    /**
     * Get tag
     *
     * @return \Application\Refactor\ReferenceBundle\Entity\Tag 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set fiche
     *
     * @param \Application\Refactor\ReferenceBundle\Entity\Fiche $fiche
     * @return FicheTag
     */
    public function setFiche(\Application\Refactor\ReferenceBundle\Entity\Fiche $fiche = null)
    {
        $this->fiche = $fiche;
    
        return $this;
    }

    /**
     * Get fiche
     *
     * @return \Application\Refactor\ReferenceBundle\Entity\Fiche 
     */
    public function getFiche()
    {
        return $this->fiche;
    }
}