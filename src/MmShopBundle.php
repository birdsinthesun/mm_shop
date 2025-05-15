<?php
namespace Bits\MmShopBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;



class MmShopBundle extends Bundle
{
    
     public function getPath(): string
    {
        return \dirname(__DIR__.'../');
    }

     public function build(ContainerBuilder $container): void
    {
         $projectDir = $container->getParameter('kernel.project_dir').'/vendor/birdsinthesun/mm_shop';
        $loader = new YamlFileLoader($container, new FileLocator($projectDir.'/config')); 
        $loader->load('services.yaml');
        // Füge einen Alias hinzu
        $container->setAlias('mm_shop_bundle', self::class);
         
         parent::build($container);
    }

}
