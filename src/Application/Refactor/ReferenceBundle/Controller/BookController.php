<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Application\Refactor\ReferenceBundle\Entity\Book;
use Application\Refactor\ReferenceBundle\Form\BookType;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\SecurityExtraBundle\Annotation\Secure;

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

    /**
     * @Secure(roles="ROLE_ADMIN")
     */

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

    /**
     * @Secure(roles="ROLE_ADMIN")
     */

    public function editAction($id)
    {
        $em  =$this->getDoctrine()->getManager();
        $book = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findOneById($id);
        $liste_projects = $book->getFiches();
        return $this->render('ApplicationRefactorReferenceBundle:Book:edit.html.twig', array(
            'projects' => $liste_projects,
            'book' => $book,
            // 'form' => $form->createView()
            ));
    }

    /**
     * @Secure(roles="ROLE_ADMIN")
     */

    public function addAction()
    {
        $book = new Book();
        $form = $this->createForm(new BookType, $book);


        $em = $this->getDoctrine()->getManager();
        $liste_projects = new ArrayCollection();
        if(isset($_POST['project'])){
        foreach ($_POST['project'] as $post) {
            $project =$em->getRepository('ApplicationRefactorReferenceBundle:fiche')->findOneById($post);
            $liste_projects->add($project); 
            $book->addFiche($project); 

            // echo("<script>console.log('".var_dump($post)."');</script>");
        }
    }
        $request = $this->get('request');
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if($form->isValid())
            {
                var_dump($liste_projects);
                foreach ($liste_projects as $project) {
                  $book->addFiche($project); 
                  echo("<script>console.log('projefjzefzojebfbisdfsdbfsdbvsdbuv');</script>");
                }
                $em = $this->getDoctrine()->getManager();
                $book->prePersist();
                $em->persist($book);
                $em->flush();

                // return $this->redirect($this->generateUrl('refactor_projects'));
            }
        }
        return $this->render('ApplicationRefactorReferenceBundle:Book:add.html.twig', array(
                'form' => $form->createView(),
                // 'title' => 'test'
                'projects' => $liste_projects
            ));
    }
}
