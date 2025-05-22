<?php

namespace Bits\MmShopBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Bits\MmShopBundle\DependencyInjection\MailCompilerPass;
use Bits\MmShopBundle\DependencyInjection\RoutingCompilerPass;

use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class MmShopBundle extends Bundle 
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }


    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        // CompilerPasses 
        $container->addCompilerPass(new RoutingCompilerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 200);
        $container->addCompilerPass(new MailCompilerPass());
    }
    
   
}
