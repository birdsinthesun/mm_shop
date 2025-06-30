<?php

namespace Bits\MmShopBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Bits\MmShopBundle\Service\ClientService;

class ClientCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(ClientService::class)) {
            return;
        }

        $definition = $container->getDefinition(ClientService::class);
        
        $definition
        ->setPublic(true);
        $container->setDefinition(ClientService::class, $definition);
        
    }
}
