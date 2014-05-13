<?php
namespace Application\Refactor\ReferenceBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Application\Sonata\UserBundle\Entity\User;

class SaltUserRestController extends Controller
{

    /**
     * Get Fiche action
     * @var integer $id Id of the Fiche
	 * @return array
     * @View(serializerGroups={"sonata_api_read"}, serializerEnableMaxDepthChecks=true)
     * 
	 */
	public function getUserAction($username){
  	    $em  =$this->getDoctrine()->getManager();
    	$User = $em->getRepository('ApplicationSonataUserBundle:User')->findOneByUsername($username);
    	if(!is_object($User)){
    		throw $this->createNotFoundException();
    	}
    	return array('salt' => $User->getSalt(),
            );
    }
}