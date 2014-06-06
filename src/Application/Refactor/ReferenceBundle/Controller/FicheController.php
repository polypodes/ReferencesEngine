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

// use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Fiche Controller
 *
 */

class FicheController extends Controller
{

    /**
     * SaveFiche($form, $project, $liste_tags, $liste_medias, $liste_renders, $MediaManager, $em)
     *
     * @Secure(roles="ROLE_ADMIN")
     *
     */
    public function saveFiche($form, $project, $liste_tags, $liste_medias, $liste_renders, $MediaManager, $em)
    {
        if (is_uploaded_file($form->get('image_input')->getData())) {
            $image = new Media();
            $image->setBinaryContent($form->get('image_input')->getData());
            $image->setContext('default');
            $image->setProviderName('sonata.media.provider.image');
            $project->setImage($image);
            $MediaManager->save($image);
        }

        if (is_object($project->getMedias())) {
            $project->getTags()->clear();
            $project->getMedias()->clear();
            $project->getRenders()->clear();
        }

        $data_tag = new ArrayCollection();
        foreach ($form->get('tags')->getData() as $tagin) {
            $tag = $em->getRepository('ApplicationRefactorReferenceBundle:Tag')->findOneByTitle($tagin->getTitle());
            if (!$data_tag->contains($tag)) {
                if ($tag == null) {
                    $tagin->prePersist();
                    $em->persist($tagin);
                    $tag = $tagin;
                }

                $project->addTag($tag);
                $data_tag->add($tag);
            }
        }

        if ($liste_tags != null) {
            foreach ($liste_tags as $tag) {
                if ($project->getTags()->contains($tag) == false) {
                    $project->removeTag($tag);
                }
            }

            foreach ($liste_renders as $render) {
                if ($project->getRenders()->contains($render) == false) {
                    $project->removeRender($render);
                }
            }

            foreach ($liste_medias as $media) {
                if ($project->getMedias()->contains($media) == false) {
                    $project->removeMedia($media);
                }
            }
        }//end if

        foreach ($form->get('medias') as $media) {
            $media_data     = $media->getData();
            $media_selector = $media->get('media_selector')->getData();
            if ($media_selector == null) {
                $media_data->setContext('default');
                $project->addMedia($media_data);
                $MediaManager->save($media_data);
            } elseif ($project->getMedias()->contains($media_selector) == false) {
                $project->addMedia($media_selector);
            }
        }

        foreach ($form->get('renders') as $render) {
            $render_data     = $render->getData();
            $render_selector = $render->get('render_selector')->getData();
            if ($render_selector == null) {
                $render_data->setContext('default');
                $render_data->setProviderName('sonata.media.provider.image');
                $project->addRender($render_data);
                $MediaManager->save($render_data);
            } elseif ($project->getRenders()->contains($render_selector) == false) {
                $project->addRender($render_selector);
            }
        }

        if ($project->getCreatedAt() == null) {
            $project->prePersist();
        } else {
            $project->preUpdate();
        }

        $em->persist($project);
        $em->flush();

    }//end saveFiche()

    /**
     * indexAction($sort)
     * List all the fiches by sort
     * @Secure(roles="ROLE_ADMIN")
     */

    public function indexAction($sort)
    {
        if ($sort != null){
            $repository = $this->getDoctrine()->getRepository('ApplicationRefactorReferenceBundle:Fiche');

            if ($sort == "old"){
                $query = $repository->createQueryBuilder('F')
                                    ->orderBy('F.date', 'ASC')
                                    ->getQuery();

                $projects = $query->getResult();

            } elseif ($sort == "recent"){
                $query = $repository->createQueryBuilder('F')
                                ->orderBy('F.date', 'DESC')
                                ->getQuery();

                $projects = $query->getResult();

            } elseif ($sort == "asc"){
                $query = $repository->createQueryBuilder('F')
                                ->orderBy('F.title', 'ASC')
                                ->getQuery();

                $projects = $query->getResult();

            } elseif ($sort == "desc"){
                $query = $repository->createQueryBuilder('F')
                                ->orderBy('F.title', 'DESC')
                                ->getQuery();

                $projects = $query->getResult();

            } 
        } else {
            $em    = $this->getDoctrine()->getManager();
            $projects = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findAll();

        }

        return $this->render(
            'ApplicationRefactorReferenceBundle:Fiche:showList.html.twig', array('projects' => $projects)
        );

    }//end indexAction()




    public function removeAction($id)
    {
        $em      = $this->getDoctrine()->getManager();
        $project = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findOneById($id);
        if (!$project) {
            throw $this->createNotFoundException('Fiche inexistant(id = '.$id.')');
        }

        $em->remove($project);
         $em->flush();

        return $this->redirect( $this->generateURL('refactor_projects'));

    }//end removeAction()

    /**
     * addAction()
     * add a fiche
     * @Secure(roles="ROLE_ADMIN")
     */

    public function addAction()
    {
        $MediaManager = $this->container->get('sonata.media.manager.media');
        $em           = $this->getDoctrine()->getManager();
        $allTags      = $em->getRepository('ApplicationRefactorReferenceBundle:Tag')->findAll();
        $fiche        = new Fiche;
        $form         = $this->createForm(new FicheType, $fiche);
        $request      = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $projet = new Fiche();
                $projet->setTitle($form->get('title')->getData());
                $projet->setContent($form->get('content')->getData());
                $projet->setPublished($form->get('published')->getData());
                $projet->setTitle2($form->get('title2')->getData());
                $projet->setDate($form->get('date')->getData());
                if (is_uploaded_file($form->get('image_input')->getData())) {
                    $image = new Media();
                    $image->setBinaryContent($form->get('image_input')->getData());
                    $image->setContext('default');
                    $image->setProviderName('sonata.media.provider.image');
                    $projet->setImage($image);
                    $MediaManager->save($image);
                } else {
                    $projet->setImage($form->get('image')->getData());
                }

                $data_tag = new ArrayCollection();
                foreach ($form->get('tags')->getData() as $tagin) {
                    $tag = $em->getRepository('ApplicationRefactorReferenceBundle:Tag')->findOneByTitle($tagin->getTitle());
                    if (!$data_tag->contains($tag)) {
                        if ($tag == null) {
                            $tagin->prePersist();
                            $em->persist($tagin);
                            $tag = $tagin;
                        }

                        $projet->addTag($tag);
                        $data_tag->add($tag);
                    }
                }

                $data_media  = new ArrayCollection();
                $data_render = new ArrayCollection();
                foreach ($form->get('medias') as $media) {
                    $media_data     = $media->getData();
                    $media_selector = $media->get('media_selector')->getData();
                    if ($media_selector == null) {
                        $media_data->setContext('default');
                        $MediaManager->save($media_data);
                        $projet->addMedia($media_data);
                    } elseif (!$data_media->contains($media_selector)) {
                        $projet->addMedia($media_selector);
                        $data_media->add($media_selector);
                    }
                }

                foreach ($form->get('renders') as $render) {
                    $render_data     = $render->getData();
                    $render_selector = $render->get('render_selector')->getData();
                    if ($render_selector == null) {
                        $render_data->setContext('default');
                        $render_data->setProviderName('sonata.media.provider.image');
                        $MediaManager->save($render_data);
                    } elseif (!$data_render->contains($render_selector)) {
                        $projet->addMedia($media_selector);
                        $data_render->add($media_selector);
                    }
                }

                $projet->prePersist();
                $em->persist($projet);
                $em->flush();

                return $this->redirect($this->generateUrl('refactor_show_projects', array('id' => $projet->getId())));
                // $url = $this->container->get('request')->headers->get('referer');
                // if (empty($url)) {
                //     $url = $this->container->get('router')->generate('_welcome');
                // }
                // return new RedirectResponse($url);
            }//end if
        }//end if

        return $this->render(
            'ApplicationRefactorReferenceBundle:Fiche:add.html.twig', array(
                                                                       'form' => $form->createView(),
                                                                       'tags' => $allTags,
                                                                      )
        );

    }//end addAction()

    /**
     * showAction($id)
     * show a fiche (depreciated)
     * @Secure(roles="ROLE_ADMIN")
     */
    public function showAction($id)
    {
        $em      = $this->getDoctrine()->getManager();
        $project = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findOneById($id);
        if (!$project) {
            throw $this->createNotFoundException('Fiche inexistant(id = '.$id.')');
        }

        return $this->render(
            'ApplicationRefactorReferenceBundle:Fiche:show.html.twig', array('project' => $project)
        );

    }//end showAction()

    /**
     * editAction($id)
     * edit a fiche
     * @Secure(roles="ROLE_ADMIN")
     */
    public function editAction($id)
    {
        $em            = $this->getDoctrine()->getManager();
        $allMedia      = $em->getRepository('ApplicationSonataMediaBundle:Media')->findAll();
        $project       = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findOneById($id);
        $allTags       = $em->getRepository('ApplicationRefactorReferenceBundle:Tag')->findAll();
        $liste_tags    = new ArrayCollection();
        $liste_medias  = new ArrayCollection();
        $liste_renders = new ArrayCollection();
        $MediaManager  = $this->container->get('sonata.media.manager.media');

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

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                if (is_uploaded_file($form->get('image_input')->getData())) {
                    $image = new Media();
                    $image->setBinaryContent($form->get('image_input')->getData());
                    $image->setContext('default');
                    $image->setProviderName('sonata.media.provider.image');
                    $project->setImage($image);
                    $MediaManager->save($image);
                }

                $this->saveFiche($form, $project, $liste_tags, $liste_medias, $liste_renders, $MediaManager, $em);

                return $this->redirect($this->generateUrl('refactor_edit_projects', array('id' => $id)));
            }
        }

        return $this->render(
            'ApplicationRefactorReferenceBundle:Fiche:edit.html.twig', array(
                                                                        'project' => $project,
                                                                        'tags'    => $allTags,
                                                                        'image'   => $project->getImage(),
                                                                        'form'    => $form->createView(),
                                                                       )
        );

    }//end editAction()
}//end class