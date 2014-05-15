<?php
namespace Application\Refactor\ReferenceBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Application\Refactor\ReferenceBundle\Entity\Book;

class BookRestController extends Controller
{

    /**
     * Get Book action
     * @var integer $id Id of the Book
	 * @return array
     * @View(serializerGroups={"sonata_api_read", "Book", "Fiche"}, serializerEnableMaxDepthChecks=true)
     * 
	 */
	public function getBookAction($id){
  	    $em  =$this->getDoctrine()->getManager();
    	$Book = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findOneById($id);
    	if(!is_object($Book)){
    		throw $this->createNotFoundException();
    	}
    	return array('Book' => $Book,
            );
    }

    /**
     * @return array
     * @View(serializerGroups={"sonata_api_read", "Book", "Fiche"}, serializerEnableMaxDepthChecks=true)
     * 
     */

    public function getBooksAction()
    {
    	$em  =$this->getDoctrine()->getManager();
    	$Books = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findAll();
    	if(!($Books)){
    		throw $this->createNotFoundException();
    	}
    	return array('Books' => $Books);
    }
}