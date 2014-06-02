<?php
namespace Application\Refactor\ReferenceBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Book Rest Controller
 * Controle Api for book
 */

class BookRestController extends Controller
{

    /**
     * Get Book action
     * @var integer $id Id of the Book
     * @return array
     * @View(serializerGroups={"sonata_api_read", "Book", "Fiche"}, serializerEnableMaxDepthChecks=true)
     * @ApiDoc(
     *  resource=true,
     *  description="Return a book with his id",
     *  output={"class"="Application\Refactor\ReferenceBundle\Entity\Book", "groups"="Book"},
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="which book you want to return"
     *      },
     *  },
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized by the wsse",
     *         404={
     *           "Returned when the book is not found",
     *         }
     *     }
     * )
     *
     */
    public function getBookAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Book = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findOneById($id);
        if (!is_object($Book)) {
               throw $this->createNotFoundException();
        }

        return array('Book' => $Book);

    }//end getBookAction()

    /**
     * @return array
     * @View(serializerGroups={"sonata_api_read", "Book", "Fiche"}, serializerEnableMaxDepthChecks=true)
     * @ApiDoc(
     *  resource=true,
     *  description="Return aall books",
     *  output={"class"="Application\Refactor\ReferenceBundle\Entity\Book", "groups"="Book"},
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized by the wsse",
     *     }
     * )
     *
     */

    public function getBooksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Books = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findAll();
        if (!($Books)) {
               throw $this->createNotFoundException();
        }

        return array('Books' => $Books);

    }//end getBooksAction()
}//end class
