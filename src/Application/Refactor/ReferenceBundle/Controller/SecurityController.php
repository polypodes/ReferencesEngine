<?php

namespace Application\Refactor\ReferenceBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\View\View as FOSView;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SecurityController extends Controller
{

    /**
     * WSSE Token generation
     *
     * @return FOSView
     * @throws AccessDeniedException
     * @ApiDoc(
     *  resource=true,
     *  description="Return a token",
     *  requirements={
     *      {
     *          "name"="username",
     *          "dataType"="string",
     *          "description"="Your Username"
     *      },
     *      {
     *          "name"="password",
     *          "dataType"="string",
     *          "description"="Your Password"
     *      },
     *  },
     *  statusCodes={
     *         200="Returned when successful",
     *         401={
     *           "Returned for any error encountered",
     *         }
     *     }
     * )
     */
    public function postTokenCreateAction()
    {
        $view    = FOSView::create();
        $request = $this->getRequest();
        $realm = $this->getRequest()->getHost();

        $username = $request->request->get('username');
        $password = $request->request->get('password');

        if((null === $username) || (null === $password)) {
            throw new UnauthorizedHttpException($realm,'Bad payload.');
        }

        $em   = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ApplicationSonataUserBundle:User')->findOneByUsername($username);
        $encoder_service = $this->get('security.encoder_factory');
        $encoder      = $encoder_service->getEncoder($user);
        $encoded_pass = $encoder->encodePassword($password, $user->getSalt());

        if (!$user) {
            throw new UnauthorizedHttpException($realm,'Bad payload');
        }

        $created   = date('c');
        $nonce     = substr(md5(uniqid('nonce_', true)), 0, 16);
        $nonceHigh = base64_encode($nonce);
        //generate Nonce
        $passwordDigest = base64_encode(sha1($nonce.$created.$encoded_pass, true));
        //generate passwordDigest
        $header = "UsernameToken Username=\"{$username}\", PasswordDigest=\"{$passwordDigest}\", Nonce=\"{$nonceHigh}\", Created=\"{$created}\"";
        //generate header
        $view->setHeader('Authorization', 'WSSE profile="UsernameToken"');
        $view->setHeader('x-wsse', "UsernameToken Username=\"{$username}\", PasswordDigest=\"{$passwordDigest}\", Nonce=\"{$nonceHigh}\", Created=\"{$created}\"");
        $data = array('x-wsse' => $header);
        $view->setStatusCode(200)->setData($data);

        return $view;

    }//end postTokenCreateAction()
}//end class
