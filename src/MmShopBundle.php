<?php

namespace Bits\MmShopBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Bits\MmShopBundle\DependencyInjection\MailCompilerPass;
use Bits\MmShopBundle\DependencyInjection\RoutingCompilerPass;
use Bits\MmShopBundle\DependencyInjection\FormCompilerPass;
use Bits\MmShopBundle\DependencyInjection\FieldCompilerPass;
use Bits\MmShopBundle\DependencyInjection\TwigCompilerPass;
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

        $container->addCompilerPass(new TwigCompilerPass());
        $container->addCompilerPass(new FieldCompilerPass());
        $container->addCompilerPass(new FormCompilerPass());
        $container->addCompilerPass(new RoutingCompilerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 100);
        $container->addCompilerPass(new MailCompilerPass());
    }
    
   
}
