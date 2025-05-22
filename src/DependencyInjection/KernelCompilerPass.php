<?php

namespace Bits\MmShopBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Bits\MmShopBundle\EventListener\KernelRequestListener;

class KernelCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(KernelRequestListener::class)) {
            return;
        }

        $definition = $container->getDefinition(KernelRequestListener::class);
        //var_dump(get_class_methods($definition));exit;
         $definition->addTag('kernel.event_listener',[
        'event' =>'kernel.request','method'=>'onKernelRequest','priority'=> 255])
        ->setPublic(true);
        $container->setDefinition(KernelRequestListener::class, $definition);
        
    }
}
