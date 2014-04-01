<?php

namespace Application\Refactor\ReferenceBundle\Entity;
use Application\Refactor\ReferenceBundle\Model\Fiche as FicheModel;


/**
 * @author <yourname> <youremail>
 */
class Fiche extends FicheModel
{
    public function prePersist()
    {
        $this->created_at = new \DateTime;
        $this->updated_at = $this->created_at;
    }

    public function preUpdate()
    {
        $this->updated_at = new \DateTime;
    }

}
