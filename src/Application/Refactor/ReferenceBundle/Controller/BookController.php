<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BookController extends Controller
{
    public function indexAction()
    {
    	$em  =$this->getDoctrine()->getManager();
        $projects = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findAll();

        return $this->render('ApplicationRefactorReferenceBundle:Default:index.html.twig', array(
    	'projects' =>$projects
        ));
    }
}
