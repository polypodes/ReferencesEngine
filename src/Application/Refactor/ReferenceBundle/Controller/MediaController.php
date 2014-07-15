<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sonata\MediaBundle\Entity\MediaManager;
use Application\Sonata\MediaBundle\Entity\Media;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Application\Refactor\ReferenceBundle\Form\Type\MediaType;
use Application\Refactor\ReferenceBundle\Form\Type\MediaEditType;

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
        $em  = $this->getDoctrine()->getManager();
        $medias = $em->getRepository('ApplicationSonataMediaBundle:Media')->findAll();

        return $this->render(
            'ApplicationRefactorReferenceBundle:Media:index.html.twig',
            array('medias' => $medias)
        );

    }//end indexAction()

    /**
     * addAction()
     * add Media
     * @Secure(roles="ROLE_ADMIN")
     */

    public function addAction()
    {
        $MediaManager = $this->container->get('sonata.media.manager.media');
        $em           = $this->getDoctrine()->getManager();
        $media        = new Media;

        $form    = $this->createForm(new MediaType, $media);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
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

        return $this->render(
            'ApplicationRefactorReferenceBundle:Media:add.html.twig',
            array(
             'form' => $form->createView(),
            )
        );

    }//end addAction()

    /**
     * editAction()
     * edit Media
     * @Secure(roles="ROLE_ADMIN")
     */

    public function editAction($id)
    {
        $MediaManager = $this->container->get('sonata.media.manager.media');
        $em           = $this->getDoctrine()->getManager();
        $media        = $em->getRepository('ApplicationSonataMediaBundle:Media')->findOneById($id);

        $form    = $this->createForm(new MediaEditType, $media);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            $MediaManager->save($media);

            return $this->redirect($this->generateUrl('refactor_medias'));
        }

        return $this->render(
            'ApplicationRefactorReferenceBundle:Media:edit.html.twig',
            array(
             'form' => $form->createView(),
             'media' => $media
            )
        );

    }//end editAction()

    /**
     * Remove a media
     * @Secure(roles="ROLE_ADMIN")
     */
    public function removeAction($id)
    {
        $em  =$this->getDoctrine()->getManager();
        $media = $em->getRepository('ApplicationSonataMediaBundle:Media')->findOneById($id);
        var_dump($media);
        exit;
        if (!$media) {
            throw $this->createNotFoundException('Media not found (id = '.$id.')');
        }
        $em->remove($media);
        $em->flush();

        return $this->redirect($this->generateURL('refactor_medias'));
    }
}//end class
