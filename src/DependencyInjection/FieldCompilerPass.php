<?php

namespace Bits\MmShopBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Bits\MmShopBundle\Form\DescriptedChoiceType;

class FieldCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(DescriptedChoiceType::class)) {
            return;
        }

        $definition = $container->getDefinition(DescriptedChoiceType::class);
        
        $definition
        ->setPublic(true);
        $container->setDefinition(DescriptedChoiceType::class, $definition);
        
    }
}
