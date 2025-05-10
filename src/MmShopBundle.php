<?php
namespace Bits\MmShopBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;

class MmShopBundle extends AbstractBundle
{
    
     public function build(ContainerBuilder $container): void
    {
        
        $projectDir = $container->getParameter('kernel.project_dir').'/vendor/birdsinthesun/mm_shop';
        $loader = new YamlFileLoader($container, new FileLocator($projectDir.'/config')); 
        $loader->load('services.yaml');
        $loader2 = new PhpFileLoader($container, new FileLocator($projectDir. '/config'));
       
        $loader2->load('bundles.php');
        parent::build($container);

       // $container->addCompilerPass(new RemoveContaoCallbackPass(),PassConfig::TYPE_BEFORE_OPTIMIZATION, 100);
       // $container->addCompilerPass(new MakeListenerPublicPass());
     
    }
    protected function addCompilerPass($compilerPass, $type = PassConfig::TYPE_AFTER_REMOVING, $priority = 0)
    {
        // Dies stellt sicher, dass der CompilerPass korrekt registriert wird.
        $this->container->addCompilerPass($compilerPass, $type, $priority);
    }

}
