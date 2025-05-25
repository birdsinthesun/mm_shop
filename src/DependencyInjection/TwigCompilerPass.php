<?php

namespace Bits\MmShopBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('twig.loader.native_filesystem')) {
            return;
        }

        $definition = $container->getDefinition('twig.loader.native_filesystem');
        
        $bundleViewsPath = __DIR__ . '/../../views';

        $definition->addMethodCall('addPath', [$bundleViewsPath, 'MmShop']);
        
    }
}
