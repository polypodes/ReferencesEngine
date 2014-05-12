<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Application\Refactor\ReferenceBundle\Entity\Book;
use Application\Refactor\ReferenceBundle\Form\BookType;
use Doctrine\Common\Collections\ArrayCollection;

class BookController extends Controller
{
    public function indexAction()
    {
    	$em  =$this->getDoctrine()->getManager();
        $books = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findAll();

        return $this->render('ApplicationRefactorReferenceBundle:Book:index.html.twig', array(
    	'books' =>$books
        ));
    }
    public function removeAction($id)
    {
        $em  =$this->getDoctrine()->getManager();
        $book = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findOneById($id);
        if(!$book)
        {
            throw $this->createNotFoundException('Cahier inexistant(id = '.$id.')');
        }
        $em->remove($book);
        $em->flush();
        return $this->redirect( $this->generateURL('refactor_books'));
    }
    public function showAction($id)
    {


    }
    public function editAction($id)
    {
        $em  =$this->getDoctrine()->getManager();
        $book = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findOneById($id);
        $liste_projects = $book->getFiches();
        return $this->render('ApplicationRefactorReferenceBundle:Book:edit.html.twig', array(
            'projects' => $liste_projects,
            // 'book' => $book,
            // 'form' => $form->createView()
            ));
    }

        public function addAction()
    {
        $Book = new Book;
        $em = $this->getDoctrine()->getManager();
        $liste_projects = new ArrayCollection();
        foreach ($_POST as $post =>$id) {
            $liste_projects->add($em->getRepository('ApplicationRefactorReferenceBundle:fiche')->findOneById($id)); 
            // $project=$em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findOneById($id);
            // $Book->addFiche($project);
            // var_dump($project);
        }
        // $Book->setTitle('test');
        // $Book->addFiche($em->getRepository('ApplicationRefactorReferenceBundle:fiche')->findOneById(2));
        $form = $this->createForm(new BookType, $Book);
        // $form->setValue('clientName', 'teztetrz');
        var_dump($form);
        $request = $this->get('request');
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if($form->isValid())
            {
                $book->prePersist();
                $em->persist($book);
                $em->flush();
                return $this->redirect($this->generateUrl('refactor_show_projects', array('id' => $book->getId())));
            }
        }
        return $this->render('ApplicationRefactorReferenceBundle:Book:add.html.twig', array(
                'form' => $form->createView(),
                // 'title' => 'test'
                'projects' => $liste_projects
            ));
    }
}
