<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Application\Refactor\ReferenceBundle\Form\FicheType;
use Application\Refactor\ReferenceBundle\Form\FicheEditType;
use Application\Refactor\ReferenceBundle\Entity\Fiche;
use Application\Refactor\ReferenceBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\MediaManager;
use Application\Sonata\MediaBundle\Entity\Media;
use JMS\SecurityExtraBundle\Annotation\Secure;

class FicheController extends Controller
{
    public function chooseMedias()
    {
        $em  =$this->getDoctrine()->getManager();
        $medias = $em->getRepository('ApplicationSonataMediaBundle:Media')->findAll();

    }
    public function indexAction()
    {
    	$em  =$this->getDoctrine()->getManager();
        $projects = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findAll();
        // foreach ($projects as $project) {
        //     $project->setImage($em->getRepository('ApplicationSonataMediaBundle:Media')->findOnebyId($project->getImage()));
        // }
        return $this->render('ApplicationRefactorReferenceBundle:Fiche:showList.html.twig', array(
    	'projects' =>$projects,
        ));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */

    public function removeAction($id)
    {
        $em  =$this->getDoctrine()->getManager();
        $project = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findOneById($id);
        if(!$project)
        {
            throw $this->createNotFoundException('Fiche inexistant(id = '.$id.')');
        }
        // echo "<script>alert(\"".$project->getTitle()."\")</script>"; 
         $em->remove($project);
         $em->flush();
        return $this->redirect( $this->generateURL('refactor_projects'));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */

    public function addAction()
    {
        $fiche = new Fiche;
        $form = $this->createForm(new FicheType, $fiche);

        $request = $this->get('request');
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $fiche->prePersist();
                $em->persist($fiche);
                $em->flush();
                return $this->redirect($this->generateUrl('refactor_show_projects', array('id' => $fiche->getId())));
            }
        }
        return $this->render('ApplicationRefactorReferenceBundle:Fiche:add.html.twig', array(
                'form' => $form->createView()
            ));
    }

    public function showAction($id)
    {
        $em  =$this->getDoctrine()->getManager();
        $project = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findOneById($id);
        if(!$project)
        {
            throw $this->createNotFoundException('Fiche inexistant(id = '.$id.')');
        }
        $liste_media= [];
        $medias = $project->getMedias();
        // foreach ($medias as $media) {
        //     $liste_media[]=$media->getMedia();
        // }
        $liste_render= [];
        $renders = $project->getRenders();
        // foreach ($renders as $render) {
        //     $liste_render[]=$render->getMedia();
        // }
         // $fichemedias= $em->getRepository('ApplicationRefactorReferenceBundle:FicheMedia')->findByFiche($project);
         // $medias=$em->getRepository('ApplicationSonataMediaBundle:Media')->findByFiche($project);

        return $this->render('ApplicationRefactorReferenceBundle:Fiche:show.html.twig', array(
            'project' => $project,
            'medias' => $medias,
            'renders' => $renders
            ));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */

    public function editAction($id)
    {
        $em  =$this->getDoctrine()->getManager();
        $allMedia = $em->getRepository('ApplicationSonataMediaBundle:Media')->findAll();
        $project = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findOneById($id);
        $liste_tags = new ArrayCollection();
        $liste_medias = new ArrayCollection();
        $liste_renders = new ArrayCollection();
        $MediaManager = $this->container->get('sonata.media.manager.media');

        foreach ($project->getTags() as $tag) {

            $liste_tags->add($tag);
        }
        foreach ($project->getMedias() as $media) {

            $liste_medias->add($media);
        }
        foreach ($project->getRenders() as $render) {

            $liste_renders->add($render);
        }
        $form = $this->createForm(new FicheEditType(), $project, array('em' => $this->getDoctrine()->getManager(),));

        $request = $this->get('request');

        if($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if($form->isValid())
            {
                $project->getTags()->clear();
                $project->getMedias()->clear();
                $project->getRenders()->clear();
                $em->persist($project);

                foreach ($form->get('tags')->getData() as $tag) {
                    $project->addTag($tag);
                    $tag->prePersist();
                    // $tag->setCreatedAt(new \DateTime);
                    $em->persist($tag);
                }
                foreach ($liste_tags as $tag) {
                    if ($project->getTags()->contains($tag) == false) 
                        {
                        $project->removeTag($tag);
                        }
                    }
                foreach ($form->get('medias')->getData() as $media) {
                    // $tag->setCreatedAt(new \DateTime);
                    $media->setContext('default');
                    $project->addMedia($media);
                    $MediaManager->save($media);
                    $em->persist($media);
                }
                foreach ($liste_medias as $media) {
                    if ($project->getMedias()->contains($media) == false) 
                        {
                        $project->removeMedia($media);
                        }
                    }
                foreach ($form->get('renders')->getData() as $render) {
                    $render->setContext('default');
                    $render->setProviderName('sonata.media.provider.image');
                    $project->addRender($render);
                    $MediaManager->save($render);
                    $em->persist($render);
                }
                foreach ($liste_renders as $render) {
                    if ($project->getRenders()->contains($render) == false) 
                        {
                        $project->removeRender($render);
                        }
                    }
                 $em->flush();
                return $this->redirect($this->generateUrl('refactor_show_projects', array('id' => $id)));
            }
        }

        return $this->render('ApplicationRefactorReferenceBundle:Fiche:edit.html.twig', array(
            'project' => $project,
            // 'medias' => $liste_media,
            'image' => $project->getImage(),
            // 'renders' => $liste_render,
            'form' => $form->createView()
            ));
    }
}