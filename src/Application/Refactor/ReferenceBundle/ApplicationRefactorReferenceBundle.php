<?php

namespace Application\Refactor\ReferenceBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Application\Refactor\ReferenceBundle\DependencyInjection\Security\Factory\WsseFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ApplicationRefactorReferenceBundle extends Bundle
{
	public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new WsseFactory());
    }
}
