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
