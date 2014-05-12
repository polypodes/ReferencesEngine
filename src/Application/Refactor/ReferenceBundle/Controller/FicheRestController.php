<?php
namespace Application\Refactor\ReferenceBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Application\Refactor\ReferenceBundle\Entity\Fiche;

class FicheRestController extends Controller
{

    /**
     * Get Fiche action
     * @var integer $id Id of the Fiche
	 * @return array
     * @View(serializerGroups={"sonata_api_read", "Fiche"}, serializerEnableMaxDepthChecks=true)
     * 
	 */
	public function getFicheAction($id){
  	    $em  =$this->getDoctrine()->getManager();
    	$fiche = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findOneById($id);
    	if(!is_object($fiche)){
    		throw $this->createNotFoundException();
    	}
    	return array('fiche' => $fiche,
            );
    }

    /**
     * @return array
     * @View(serializerGroups={"sonata_api_read", "Fiche"}, serializerEnableMaxDepthChecks=true)
     * 
     */

    public function getFichesAction()
    {
    	$em  =$this->getDoctrine()->getManager();
    	$fiches = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findAll();
    	if(!($fiches)){
    		throw $this->createNotFoundException();
    	}
    	return array('fiches' => $fiches);
    }
}