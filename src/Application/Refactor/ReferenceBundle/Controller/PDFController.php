<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\MediaBundle\Entity\MediaManager;
use Application\Sonata\MediaBundle\Entity\Media;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

class PDFController extends Controller
{
    /**
     * removeAction($id)
     * remove a book
     * @Secure(roles="ROLE_ADMIN")
     */
    public function projectAction($id)
    {
    	$em  =$this->getDoctrine()->getManager();
    	$project = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findOneById($id);
        return $this->render('ApplicationRefactorReferenceBundle:Pdf:project.html.twig', array(
    	'project' => $project
        ));
    }
    /*public function projectPDFAction($id)
    {

        $em  =$this->getDoctrine()->getManager();
        $project = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findOneById($id);
        if(!$project)
        {
            throw $this->createNotFoundException('Fiche inexistant(id = '.$id.')');
        }
        $html = $this->renderView('ApplicationRefactorReferenceBundle:Fiche:show.html.twig', array(
            'project' => $project,
            ));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }*/

    public function bookAction($id)
    {
        $liste_project = new ArrayCollection();
        $em  =$this->getDoctrine()->getManager();
        $book = $em->getRepository('ApplicationRefactorReferenceBundle:book')->findOneById($id);
        foreach ($book->getFiches() as $fiche) {

            $liste_project->add($fiche);
        }
        return $this->render('ApplicationRefactorReferenceBundle:Pdf:book.html.twig', array(
        'book' => $book,
        'liste_project' =>$liste_project
        ));
    }

    /**
     * removeAction($id)
     * remove a book
     * @Secure(roles="ROLE_ADMIN")
     */

    public function bookPDFAction($id)
    {
        $html2pdf = $this->get('html2pdf')->get('');
        $em  =$this->getDoctrine()->getManager();
        $url=$this->get('router')->generate('refactor_pdf_books', array(
        'id' => $id
        ),
        true);
        $book = $em->getRepository('ApplicationRefactorReferenceBundle:book')->findOneById($id);
        $css="<style type='text/css'>".file_get_contents("css/mypdfcss.css")."</style>";
        $html= file_get_contents($url);
        $html= $this->bookAction($id);
        $html2pdf->pdf->SetAuthor($book->getClientName());
        $html2pdf->pdf->SetTitle($book->getTitle());
        $html2pdf->pdf->SetSubject($book->getProjectName());
        $html2pdf->writeHTML($css);
        $html2pdf->writeHTML($html, isset($_GET['vuehtml']));
        $html2pdf->createIndex('Summary', 25, 12, false, true, 1);
        $html2pdf->Output('Book_'.$id.'.pdf', 'D');
    }
}