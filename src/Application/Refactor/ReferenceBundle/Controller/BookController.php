<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        if(!$project)
        {
            throw $this->createNotFoundException('Cahier inexistant(id = '.$id.')');
        }
        $em->remove($book);
        $em->flush();
        return $this->redirect( $this->generateURL('refactor_books'));
    }
}
