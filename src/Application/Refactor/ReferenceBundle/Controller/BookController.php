<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Application\Refactor\ReferenceBundle\Entity\Book;
use Application\Refactor\ReferenceBundle\Form\Type\BookType;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

/**
 * Book Controller
 *
 */

class BookController extends Controller
{
    /**
     * indexAction
     * Show all books
     * @Secure(roles="ROLE_ADMIN")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findAll();

        return $this->render(
            'ApplicationRefactorReferenceBundle:Book:index.html.twig',
            array(
                'books' => $books
            )
        );
    }

    /**
     * Show a book to consult it without restriction
     * @param  integer $id [description]
     * @return [type]     [description]
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findOneById($id);

        return $this->render(
            'ApplicationRefactorReferenceBundle:Book:show.html.twig',
            compact('book')
        );
    }


    /**
     * addAction
     * add a book
     * @Secure(roles="ROLE_ADMIN")
     */
    public function addAction()
    {
        $book = new Book();
        $form = $this->createForm(new BookType, $book);

        $em = $this->getDoctrine()->getManager();

        $projects = new ArrayCollection();

        if (!empty($_POST['projects'])) {
            $projectIds = $_POST['projects'];
            if (!is_array($projectIds)) $projectIds = array($projectIds);

            $projects = new ArrayCollection(
                $em->getRepository('ApplicationRefactorReferenceBundle:fiche')->findByIds($projectIds)
            );

            //echo '<pre>'; var_dump($projects->count()); echo '</pre>';
        }

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $book = new Book();
                $book->setTitle($form->get('title')->getData());
                $book->setClientName($form->get('clientName')->getData());
                $book->setPublished($form->get('published')->getData());
                $book->setDate($form->get('date')->getData());

                foreach ($projects as $project) {
                    $book->addFiche($project);
                }
                foreach ($form->get('fiches') as $fiche) {
                    $fiche_selector= $fiche->get('fiche_selector')->getData();
                    if ($fiche_selector != null && $book->getFiches()->contains($fiche_selector) == false) {
                        $book->addFiche($fiche_selector);
                    }
                }
                $book->prePersist();
                $em->persist($book);
                $em->flush();

                return $this->redirect($this->generateUrl('refactor_edit_books', array('id' => $book->getId())));
            }
        }

        return $this->render(
            'ApplicationRefactorReferenceBundle:Book:add.html.twig', array(
                'form' => $form->createView(),
                'projects' => $projects

            )
        );
    }

    /**
     * editAction($id)
     * edit a book
     * @Secure(roles="ROLE_ADMIN")
     */

    public function editAction($id)
    {
        $em  =$this->getDoctrine()->getManager();
        $MediaManager = $this->container->get('sonata.media.manager.media');
        // $PDF = $this->forward('Application\Refactor\ReferenceBundle\Controller\PDFController:bookPDFAction'
        //, array('id' => $id));
        $book = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findOneById($id);
        $liste_fiches = new ArrayCollection();

        $liste_project = $book->getFiches();

        foreach ($book->getFiches() as $project) {

            $liste_fiches->add($project);//get all the fiche
        }
        $form = $this->createForm(new BookType(), $book);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $book->getFiches()->clear();

                foreach ($liste_fiches as $fiche) {
                    if ($book->getFiches()->contains($fiche) == false) {
                        $book->removeFiche($fiche);
                    }
                }
                foreach ($form->get('fiches') as $fiche) {
                    $fiche_data= $fiche->getData();
                    $fiche_selector= $fiche->get('fiche_selector')->getData();
                    if ($fiche_selector == null) {
                        $book->addFiche($fiche_data);
                    } elseif ($book->getFiches()->contains($fiche_selector) == false) {
                        $book->addFiche($fiche_selector);
                    }
                }
                $book->preUpdate();
                $em->persist($book);
                $em->flush();

                return $this->redirect($this->generateUrl('refactor_edit_books', array('id' => $id)));
            }
        }

        return $this->render(
            'ApplicationRefactorReferenceBundle:Book:edit.html.twig', array(
            'projects' => $liste_project,
            'book' => $book,
            'form' => $form->createView(),
            )
        );
    }

    /**
     * Remove a book
     * @Secure(roles="ROLE_ADMIN")
     */
    public function removeAction($id)
    {
        $em  =$this->getDoctrine()->getManager();
        $book = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findOneById($id);
        if (!$book) {
            throw $this->createNotFoundException('Cahier inexistant(id = '.$id.')');
        }
        $em->remove($book);
        $em->flush();

        return $this->redirect($this->generateURL('refactor_books'));
    }
}
