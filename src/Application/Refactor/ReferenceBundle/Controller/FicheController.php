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
    public function saveFiche($form, $project, $liste_tags, $liste_medias, $liste_renders, $MediaManager, $em)
    {
        if(is_uploaded_file($form->get('image_input')->getData()))
        {
            $image= new Media();
            $image->setBinaryContent($form->get('image_input')->getData());
            $image->setContext('default'); 
            $image->setProviderName('sonata.media.provider.image');
            $project->setImage($image);
            $MediaManager->save($image);
        }
        if(is_object($project->getMedias())){
            $project->getTags()->clear();
            $project->getMedias()->clear();
            $project->getRenders()->clear();
        }
                // $em->persist($project);

        foreach ($form->get('tags')->getData() as $tag) {
            $project->addTag($tag);
            $tag->prePersist();
            // $tag->setCreatedAt(new \DateTime);
            $em->persist($tag);
        }
        if ($liste_tags!=null) {
            foreach ($liste_tags as $tag) {
                if ($project->getTags()->contains($tag) == false) 
                {
                    $project->removeTag($tag);
                }
            }  
            foreach ($liste_renders as $render) {
                if ($project->getRenders()->contains($render) == false) 
                {
                    $project->removeRender($render);
                }
            }         
            foreach ($liste_medias as $media) {
                if ($project->getMedias()->contains($media) == false) 
                {
                    $project->removeMedia($media);
                }
            }
        }

               // var_dump($form->get('medias')->getData());
        foreach ($form->get('medias') as $media) {
            $media_data= $media->getData();
            $media_selector= $media->get('media_selector')->getData();            
            if ($media_selector == null) {
                // var_dump(expression)
                $media_data->setContext('default');

                $project->addMedia($media_data);
                $MediaManager->save($media_data);

            }elseif($project->getMedias()->contains($media_selector) == false){
          
                $project->addMedia($media_selector);
            
            }             
        }
        foreach ($form->get('renders') as $render) {
            $render_data= $render->getData();
            $render_selector= $render->get('render_selector')->getData();
            if ($render_selector == null) {
                $render_data->setContext('default');
                $render_data->setProviderName('sonata.media.provider.image');
                $project->addRender($render_data);
                $MediaManager->save($render_data);
            }elseif($project->getRenders()->contains($render_selector) == false){
                $project->addRender($render_selector);
            }
        }
        if($project->getCreatedAt() == null){
            $project->prePersist();
        }else{
            $project->preUpdate();
        }
        $em->persist($project);
        $em->flush();

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
        $MediaManager = $this->container->get('sonata.media.manager.media');
        $em  =$this->getDoctrine()->getManager();
        $allTags = $em->getRepository('ApplicationRefactorReferenceBundle:Tag')->findAll();
        $fiche = new Fiche;
        $form = $this->createForm(new FicheType, $fiche);
        $request = $this->get('request');
        if($request->isXmlHttpRequest())
        {
           
            var_dump($request->request->get('test'));
            // $this->saveFiche($form, $fiche, null, null, null, $MediaManager, $em);
        }
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if($form->isValid())
            {
                $this->saveFiche($form, $fiche, null, null, null, $MediaManager, $em);
                return $this->redirect($this->generateUrl('refactor_show_projects', array('id' => $fiche->getId())));
            }
        }
        return $this->render('ApplicationRefactorReferenceBundle:Fiche:add.html.twig', array(
                'form' => $form->createView(),
                'tags' =>$allTags,
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


    public function editAction($id)
    {
        $em  =$this->getDoctrine()->getManager();
        $allMedia = $em->getRepository('ApplicationSonataMediaBundle:Media')->findAll();
        $project = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findOneById($id);
        $allTags = $em->getRepository('ApplicationRefactorReferenceBundle:Tag')->findAll();
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
        $form = $this->createForm(new FicheEditType(), $project);

        $request = $this->get('request');

        if($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if($form->isValid())
            {
                if(is_uploaded_file($form->get('image_input')->getData()))
                {
            // echo("<script>alert('test');</script>");
            // $image = $form->get('image_input')->getData();
            // $project->setImage($image);
            // $MediaManager->save($image);
            $image= new Media();
            $image->setBinaryContent($form->get('image_input')->getData());
            $image->setContext('default'); 
            $image->setProviderName('sonata.media.provider.image');
            $project->setImage($image);
            $MediaManager->save($image);

                }
                // $project->getTags()->clear();
                // $project->getMedias()->clear();
                // $project->getRenders()->clear();
                // // $em->persist($project);

                // foreach ($form->get('tags')->getData() as $tag) {
                //     $project->addTag($tag);
                //     $tag->prePersist();
                //     // $tag->setCreatedAt(new \DateTime);
                //     $em->persist($tag);
                // }
                // foreach ($liste_tags as $tag) {
                //     if ($project->getTags()->contains($tag) == false) 
                //     {
                //         $project->removeTag($tag);
                //     }
                // }             
                // foreach ($liste_medias as $media) {
                //     if ($project->getMedias()->contains($media) == false) 
                //         {
                //         $project->removeMedia($media);
                //         }
                //     }

                //        // var_dump($form->get('medias')->getData());
                // foreach ($form->get('medias') as $media) {
                //     $media_data= $media->getData();
                //     $media_selector= $media->get('media_selector')->getData();
            
                //     if ($media_selector == null) {
                //         // var_dump(expression)
                //         $media_data->setContext('default');

                //         $project->addMedia($media_data);
                //         $MediaManager->save($media_data);

                //     }elseif($project->getMedias()->contains($media_selector) == false){
          
                //         $project->addMedia($media_selector);
            
                //     }
                
                //     // $tag->setCreatedAt(new \DateTime);;
                //     // $selector = $form->get('media_selector')->getData();
                //     // var_dump($media->getBinaryContent());
                //     // echo("<script>alert('".$form->get('binaryContent')->getData(."');</script>");
                //     // var_dump($form->get('medias')->getData());
                //     // $MediaManager->save($media);

                
                // }
                // foreach ($liste_renders as $render) {
                //     if ($project->getRenders()->contains($render) == false) 
                //         {
                //         $project->removeRender($render);
                //         }
                //     }

                // foreach ($form->get('renders') as $render) {
                //     $render_data= $render->getData();
                //     $render_selector= $render->get('render_selector')->getData();
                //     if ($render_selector == null) {
                //         $render_data->setContext('default');
                //         $render_data->setProviderName('sonata.media.provider.image');
                //         $project->addRender($render_data);
                //         $MediaManager->save($render_data);
                //     }elseif($project->getRenders()->contains($render_selector) == false){
                //         $project->addRender($render_selector);
                //     }
                // }
                //     $em->persist($project);
                //  $em->flush();
                $this->saveFiche($form, $project, $liste_tags, $liste_medias, $liste_renders, $MediaManager, $em);
                // return $this->redirect($this->generateUrl('refactor_show_projects', array('id' => $id)));
            }
        }

        // var_dump($form->getErrorsAsString());

        return $this->render('ApplicationRefactorReferenceBundle:Fiche:edit.html.twig', array(
            'project' => $project,
            'tags' =>$allTags,
            // 'medias' => $liste_media,
            'image' => $project->getImage(),
            // 'renders' => $liste_render,
            'form' => $form->createView()
            ));
    }
}