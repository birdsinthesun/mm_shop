<?php

namespace Bits\MmShopBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Bits\MmShopBundle\EventSubscriber\FormThemeSubscriber;

class FormCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(FormThemeSubscriber::class)) {
            return;
        }

        $definition = $container->getDefinition(FormThemeSubscriber::class);
        
        $definition
        ->setPublic(true);
        $container->setDefinition(FormThemeSubscriber::class, $definition);
        
    }
}
