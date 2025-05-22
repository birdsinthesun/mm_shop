<?php

namespace Bits\MmShopBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class MmShopExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        // Lädt services.yaml
        $loader->load('services.yaml');
       // $loader->load('packages/twig.yaml');

        // Optional: routes.yaml, falls du es brauchst
        //$loader->load('routes.yaml');
    }
}
