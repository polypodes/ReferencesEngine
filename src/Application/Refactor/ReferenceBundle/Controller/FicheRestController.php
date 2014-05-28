<?php
namespace Application\Refactor\ReferenceBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Application\Refactor\ReferenceBundle\Entity\Fiche;

/**
 * Fiche Rest Controller
 * Control Fiche Api
 */

class FicheRestController extends Controller
{

    /**
     * @return array
     * @View(serializerGroups={"sonata_api_read", "Fiche"}, serializerEnableMaxDepthChecks=true)
     *
     */
    public function getFicheAction($id)
    {
         $em      = $this->getDoctrine()->getManager();
           $fiche = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findOneById($id);
        if (!($fiche)) {
               throw $this->createNotFoundException();
        }

        return array('fiche' => $fiche);

    }//end getFicheAction()

    /**
     * @return array
     * @View(serializerGroups={"sonata_api_read", "Fiche"}, serializerEnableMaxDepthChecks=true)
     *
     */

    public function getFichesAction()
    {
           $em     = $this->getDoctrine()->getManager();
           $fiches = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findAll();
        if (!($fiches)) {
               throw $this->createNotFoundException();
        }

        return array('fiches' => $fiches);

    }//end getFichesAction()
}//end class
