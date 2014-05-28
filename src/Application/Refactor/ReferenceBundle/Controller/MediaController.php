<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\MediaManager;
use Application\Sonata\MediaBundle\Entity\Media;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Application\Refactor\ReferenceBundle\Form\MediaType;
use Application\Refactor\ReferenceBundle\Form\MediaEditType;


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
    	'medias' => $medias,
        ));
    }

    /**
     * addAction()
     * add Media
     * @Secure(roles="ROLE_ADMIN")
     */

    public function addAction()
    {
        $MediaManager = $this->container->get('sonata.media.manager.media');
        $em  =$this->getDoctrine()->getManager();
        $media = new Media;

        $form = $this->createForm(new MediaType, $media);
        $request = $this->get('request');
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            $media = new Media;
            $media->setBinaryContent($form->get('binaryContent')->getData());
            $media->setContext('default');
            $media->setDescription($form->get('description')->getData());
            $media->setName($form->get('name')->getData());
            $media->setProviderName($form->get('providerName')->getData());
            $MediaManager->save($media);
            return $this->redirect($this->generateUrl('refactor_medias'));
        }
        return $this->render('ApplicationRefactorReferenceBundle:Media:add.html.twig', array(
                'form' => $form->createView(),
            ));
    }

    /**
     * editAction()
     * edit Media
     * @Secure(roles="ROLE_ADMIN")
     */

    public function editAction($id)
    {
        $MediaManager = $this->container->get('sonata.media.manager.media');
        $em  =$this->getDoctrine()->getManager();
        $media = $em->getRepository('ApplicationSonataMediaBundle:Media')->findOneById($id);

        $form = $this->createForm(new MediaEditType, $media);
        $request = $this->get('request');
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            $MediaManager->save($media);
            return $this->redirect($this->generateUrl('refactor_medias'));
        }
        return $this->render('ApplicationRefactorReferenceBundle:Media:edit.html.twig', array(
                'form' => $form->createView(),
            ));
    }
}