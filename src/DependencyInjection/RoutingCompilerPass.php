<?php

namespace Bits\MmShopBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Bits\MmShopBundle\Routing\DynamicRouteLoader;

class RoutingCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(DynamicRouteLoader::class)) {
            return;
        }

        $definition = $container->getDefinition(DynamicRouteLoader::class);
        //var_dump(get_class_methods($definition));exit;
        $definition->addTag('routing.loader',['priority'=>200])
        ->setAutoconfigured(false)
        ->setPublic(true);
        $container->setDefinition(DynamicRouteLoader::class, $definition);
        
    }
}
