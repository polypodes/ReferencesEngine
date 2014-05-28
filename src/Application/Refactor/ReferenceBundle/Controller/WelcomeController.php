<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Welcome Controller
 *
 */

class WelcomeController extends Controller
{

    /**
     * redirectAction
     *
     */

    public function redirectAction()
    {
        return $this->redirect( $this->generateURL('refactor_projects'));

    }//end redirectAction()
}//end class
