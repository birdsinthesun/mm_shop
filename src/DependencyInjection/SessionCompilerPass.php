<?php

namespace Bits\MmShopBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Bits\MmShopBundle\EventListener\Session\SessionBagListener;

class SessionCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(SessionBagListener::class)) {
            return;
        }

        $definition = $container->getDefinition(SessionBagListener::class);
        //var_dump(get_class_methods($definition));exit;
        $definition->addTag('name: kernel.event_listener, event: kernel.request')
        ->setPublic(true);
        $container->setDefinition(SessionBagListener::class, $definition);
        
    }
}
