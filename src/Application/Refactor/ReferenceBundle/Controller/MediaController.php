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
     //    $qb = $em->CreateQueryBuilder();
     //    $medias= $qb->select('fiche.image')
     //                    ->from('ApplicationRefactorReferenceBundle:Fiche', 'fiche')
     //                    ->leftJoin('ApplicationSonataMediaBundle:Media', 'Media')
     //                    ->getQuery()
     //                    ->getResult();
     //    var_dump($medias);
        // $nots= $qb->select('media')
        //                 ->from('ApplicationSonataMediaBundle:Media', 'media')
        //                 ->where($qb->expr()->notIn('media', $nots))
        //                 ->getQuery()
        //                 ->getResult();

        $medias = $em->getRepository('ApplicationSonataMediaBundle:Media')->findAll();


//         select *
// from media__media
// where id not in(
// select media_id
// from reference__fiche_media)
// and id not in(
// select media_id
// from reference__fiche_render)
// and id not in(
// select image_id
// from reference__fiche)
        return $this->render('ApplicationRefactorReferenceBundle:Media:index.html.twig', array(
    	'medias' => $medias,
        // 'media_supp' => $medias_supp
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