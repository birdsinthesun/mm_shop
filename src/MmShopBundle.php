<?php
namespace Bits\MmShopBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
//use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;

class MmShopBundle extends Bundle
{
    
     public function getPath(): string
    {
        return \dirname(__DIR__);
    }
     public function build(ContainerBuilder $container): void
    {
        
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../config')); 
        $loader->load('services.yaml');
        $loader->load('packages/twig.yaml');
        
        
        $loader2 = new PhpFileLoader($container, new FileLocator(__DIR__.'/../config'));
       
        $loader2->load('bundles.php');
        

       // $container->addCompilerPass(new RemoveContaoCallbackPass(),PassConfig::TYPE_BEFORE_OPTIMIZATION, 100);
       // $container->addCompilerPass(new MakeListenerPublicPass());
     
        // Füge einen Alias hinzu
        $container->setAlias('mm_shop_bundle', self::class);
         
         parent::build($container);
    }
    protected function addCompilerPass($compilerPass, $type = PassConfig::TYPE_AFTER_REMOVING, $priority = 0)
    {
        // Dies stellt sicher, dass der CompilerPass korrekt registriert wird.
        $this->container->addCompilerPass($compilerPass, $type, $priority);
    }

}
