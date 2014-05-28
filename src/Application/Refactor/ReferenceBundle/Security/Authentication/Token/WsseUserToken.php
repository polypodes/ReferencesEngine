<?php
namespace Application\Refactor\ReferenceBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class WsseUserToken extends AbstractToken
{

    public $created;

    public $digest;

    public $nonce;

    public function __construct(array $roles = array())
    {
        parent::__construct($roles);
        $this->setAuthenticated(count($roles) > 0);

    }//end __construct()

    public function getCredentials()
    {
        return '';

    }//end getCredentials()
}//end class
