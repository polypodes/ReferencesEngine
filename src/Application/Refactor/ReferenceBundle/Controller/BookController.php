<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Application\Refactor\ReferenceBundle\Entity\Book;
use Application\Refactor\ReferenceBundle\Entity\Fiche;
use Application\Refactor\ReferenceBundle\Form\BookType;
use Application\Refactor\ReferenceBundle\Form\FicheType;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

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
        $MediaManager = $this->container->get('sonata.media.manager.media');
        $book = $em->getRepository('ApplicationRefactorReferenceBundle:Book')->findOneById($id);
        $fiche=new Fiche();
        $liste_fiches = new ArrayCollection();

        $liste_project = $book->getFiches();

        foreach ($book->getFiches() as $project) {

            $liste_fiches->add($project);
        }
        $form = $this->createForm(new BookType(), $book);
        // $form_fiche = $this->createForm(new FicheType(), $fiche);
         $request = $this->get('request');
          // var_dump('expression'); 

        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            // $form_fiche->bind($request);
            // if($form_fiche->isValid())
            // {
            //     $savefiche= $this->forward('saveFiche:saveFiche', array(
            //         'form' => $form_fiche,
            //         'project' => $fiche,
            //         'liste_tags' => null,
            //         'liste_medias' => null, 
            //         'liste_renders' => null, 
            //         'MediaManager' => $MediaManager, 
            //         'em'=> $em
            //         ));            

            // }
            if($form->isValid())
            {
                $book->getFiches()->clear();
                
                foreach ($liste_fiches as $fiche) {
                    if ($book->getFiches()->contains($fiche) == false) 
                    {
                        $book->removeFiche($fiche);
                    }
                }
                foreach ($form->get('fiches') as $fiche) {
                    $fiche_data= $fiche->getData();
                    $fiche_selector= $fiche->get('fiche_selector')->getData();
                    if ($fiche_selector == null) {
                        $book->addFiche($fiche_data);
                    }elseif($book->getFiches()->contains($fiche_selector) == false){
                        $book->addFiche($fiche_selector);                    
                    }
                }
                $book->preUpdate();
                $em->persist($book);
                $em->flush();

                return $this->redirect($this->generateUrl('refactor_edit_books', array('id' => $id)));
            }
        }



    return $this->render('ApplicationRefactorReferenceBundle:Book:edit.html.twig', array(
            'projects' => $liste_project,
            'book' => $book,
            'form' => $form->createView(),
            // 'formFiche' => $form_fiche->createView()
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
            // $book->addFiche($project); 

            // echo("<script>console.log('".var_dump($post)."');</script>");
            }
        }

        $request = $this->get('request');
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if($form->isValid())
            {
                foreach ($liste_projects as $project) {
                  $book->addFiche($project); 

                }
                $book->prePersist();
                $em->persist($book);
                $em->flush();

                return $this->redirect($this->generateUrl('refactor_edit_books', array('id' => $book->getId())));
            }
        }
        return $this->render('ApplicationRefactorReferenceBundle:Book:add.html.twig', array(
                'form' => $form->createView(),
                'projects' => $liste_projects

            ));
    }
}
