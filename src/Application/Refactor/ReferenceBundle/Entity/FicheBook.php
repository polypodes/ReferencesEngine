<?php

namespace Application\Refactor\ReferenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FicheBook
 *
 * @ORM\Table(name="reference__fiche_book")
 * @ORM\Entity
 */
class FicheBook
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
     * @var \Book
     *
     * @ORM\ManyToOne(targetEntity="Book")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     * })
     */
    private $book;

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
     * @return FicheBook
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
     * Set book
     *
     * @param \Application\Refactor\ReferenceBundle\Entity\Book $book
     * @return FicheBook
     */
    public function setBook(\Application\Refactor\ReferenceBundle\Entity\Book $book = null)
    {
        $this->book = $book;
    
        return $this;
    }

    /**
     * Get book
     *
     * @return \Application\Refactor\ReferenceBundle\Entity\Book 
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set fiche
     *
     * @param \Application\Refactor\ReferenceBundle\Entity\Fiche $fiche
     * @return FicheBook
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