<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Application\Refactor\ReferenceBundle\Entity\Tag;
use Application\Refactor\ReferenceBundle\Form\Type\TagType;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
class TagController extends Controller
{
    /**
     * indexAction
     * Show all tags
     * @Secure(roles="ROLE_ADMIN")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository('ApplicationRefactorReferenceBundle:Tag')->findAllOrderByTitle();

        return $this->render(
            'ApplicationRefactorReferenceBundle:Tag:index.html.twig',
            array(
                'tags' => $tags
            )
        );
    }

    /**
     * addAction
     * add a tag
     * @Secure(roles="ROLE_ADMIN")
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = new Tag;
        $form = $this->createform(new TagType, $tag);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $tag->setTitle($form->get('title')->getData());
            $tag->setSlug($form->get('slug')->getData());

            $em->persist($tag);
            $em->flush();

            $request
                ->getSession()
                ->getFlashBag()
                ->add('success', $this->get('translator')->trans(
                    'reference.tag.added',
                    array('%tag_title%' => $tag->getTitle())
                ))
            ;

            if ($form->get('saveAndAddAnother')->isClicked()) {
                return $this->redirect($this->generateUrl('refactor_tags_add'));
            } else {
                return $this->redirect($this->generateUrl(
                    'refactor_tags_edit',
                    ['id' => $tag->getId()]
                ));
            }
        }

        return $this->render(
            'ApplicationRefactorReferenceBundle:Tag:add.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * editAction($id)
     * edit a tag
     * @Secure(roles="ROLE_ADMIN")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository('ApplicationRefactorReferenceBundle:Tag')->findOneById($id);

        if (!$tag) {
            throw $this->createNotFoundException($this->get('translator')->trans('reference.tag.not_found', array('%id%' => $id)));
        }

        $form = $this->createform(new TagType, $tag);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $tag->setTitle($form->get('title')->getData());
            $tag->setSlug($form->get('slug')->getData());

            $em->persist($tag);
            $em->flush();

            $request
                ->getSession()
                ->getFlashBag()
                ->add('success', $this->get('translator')->trans(
                    'reference.tag.modified',
                    array('%tag_title%' => $tag->getTitle())
                ))
            ;

        }

        return $this->render(
            'ApplicationRefactorReferenceBundle:Tag:edit.html.twig',
            [
                'tag' => $tag,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * removeAction($id)
     * edit a tag
     * @Secure(roles="ROLE_ADMIN")
     */
    public function removeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository('ApplicationRefactorReferenceBundle:Tag')->findOneById($id);

        if (!$tag) {
            throw $this->createNotFoundException($this->get('translator')->trans('reference.tag.not_found', array('%id%' => $id)));
        }

        $request
            ->getSession()
            ->getFlashBag()
            ->add('success', $this->get('translator')->trans(
                'reference.tag.deleted',
                array('%tag_title%' => $tag->getTitle())
            ))
        ;

        $em->remove($tag);
        $em->flush();

        return $this->redirect( $this->generateURL('refactor_tags'));
    }

}
