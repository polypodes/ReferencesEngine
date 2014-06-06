<?php
namespace Application\Refactor\ReferenceBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Application\Refactor\ReferenceBundle\Entity\Fiche;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Fiche Rest Controller
 * Control Fiche Api
 */

class FicheRestController extends Controller
{

    /**
     * @return array
     * @View(serializerGroups={"sonata_api_read", "Fiche"}, serializerEnableMaxDepthChecks=true)
     * @ApiDoc(
     *  resource=true,
     *  description="Return a fiche with his id",
     *  output={"class"="Application\Refactor\ReferenceBundle\Entity\Fiche", "groups"="Fiche"},
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="which fiche you want to return"
     *      },
     *  },
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized by the wsse",
     *         404={
     *           "Returned when the fiche is not found",
     *         }
     *     }
     * )
     *
     */
    public function getFicheAction($id)
    {
        $em      = $this->getDoctrine()->getManager();
        $fiche   = $em->getRepository('ApplicationRefactorReferenceBundle:Fiche')->findOneById($id);
        if (!($fiche)) {
               throw $this->createNotFoundException();
        }

        return array('fiche' => $fiche);

    }//end getFicheAction()

        /**
     * @return array
     * @View(serializerGroups={"sonata_api_read", "Fiche"}, serializerEnableMaxDepthChecks=true)
     * @ApiDoc(
     *  resource=true,
     *  description="Return fiche with Tag ",
     *  output={"class"="Application\Refactor\ReferenceBundle\Entity\Fiche", "groups"="Fiche"},
     *  requirements={
     *      {
     *          "name"="tag",
     *          "dataType"="string",
     *          "requirement"="\w+",
     *          "description"="Use a atg for fiche"
     *      },
     *  },
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized by the wsse",
     *         404={
     *           "Returned when the fiche is not found",
     *         }
     *     }
     * )
     *
     */
    public function getFichebytagAction($tag)
    {
        $em    = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $query = $qb->select('F')
                            ->from('ApplicationRefactorReferenceBundle:Fiche', 'F')
                            ->innerJoin('F.tags', 't','WITH', 't.title=:tag') 
                            ->setParameter('tag', $tag)
                            ->getQuery();

        $fiche = $query->getResult();

        $fiche = $query->getResult();
        if (!($fiche) || is_null($tag)) {
               throw $this->createNotFoundException();
        }

        return array('fiches' => $fiche);

    }//end getFicheByTagAction()

    /**
     * @return array
     * @View(serializerGroups={"sonata_api_read", "Fiche"}, serializerEnableMaxDepthChecks=true)
     * @ApiDoc(
     *  resource=true,
     *  description="Return all fiche",
     *  output={"class"="Application\Refactor\ReferenceBundle\Entity\Fiche", "groups"="Fiche"},
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized by the wsse",
     *     }
     * )
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
