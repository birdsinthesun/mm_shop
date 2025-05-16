<?php
namespace Bits\MmShopBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use Bits\MmShopBundle\DependencyInjection\RoutingCompilerPass;



class MmShopBundle extends Bundle
{
    
     public function getPath(): string
    {
        return \dirname(__DIR__.'../');
    }

    public function loadExtension(
        array $config, 
        ContainerConfigurator $containerConfigurator, 
        ContainerBuilder $containerBuilder,
    ): void
    {
        $containerConfigurator->import('../config/services.yaml');
    }
     public function build(ContainerBuilder $container): void
    {
        
        parent::build($container);
         $projectDir = $container->getParameter('kernel.project_dir').'/vendor/birdsinthesun/mm_shop';
         $loader = new YamlFileLoader($container, new FileLocator($projectDir.'/config')); 
       //  var_dump(get_class_methods($container));
// Füge einen Alias hinzu
        $container->setAlias('mm_shop',self::class)->setPublic(true);
       // $container->registerExtension(new MmShopExtension);
        $loader->load('services.yaml');
        //$loader->load('routes.yaml');
        
       
        
         
         
         
         $container->addCompilerPass(new RoutingCompilerPass());
    }

}
