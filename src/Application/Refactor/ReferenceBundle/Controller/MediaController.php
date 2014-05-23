<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\MediaManager;
use Application\Sonata\MediaBundle\Entity\Media;
use JMS\SecurityExtraBundle\Annotation\Secure;


/**
 * Media Controller
 * 
 */

class MediaController extends Controller
{
    /**
     * indexAction()
     * show all Media
     * @Secure(roles="ROLE_ADMIN")
     */
    public function indexAction()
    {
    	$em  =$this->getDoctrine()->getManager();
        $medias = $em->getRepository('ApplicationSonataMediaBundle:Media')->findAll();
        return $this->render('ApplicationRefactorReferenceBundle:Media:index.html.twig', array(
    	'medias' => $medias
        ));
    }
}