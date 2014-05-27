<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

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
    }
}
