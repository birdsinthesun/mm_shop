<?php
namespace Bits\MmShopBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Bits\MmShopBundle\MmShopBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\RoutingBundle\RoutingBundle;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use MetaModels\CoreBundle\MetaModelsCoreBundle; 
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;

class Plugin implements BundlePluginInterface, RoutingPluginInterface
{
    

    
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(MmShopBundle::class)
                ->setLoadAfter([
                    FrameworkBundle::class,
                    TwigBundle::class,
                    RoutingBundle::class,
                    ContaoCoreBundle::class,
                    MetaModelsCoreBundle::class
                ]),
        ];
    }
    
     public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
    {
        
        //var_dump(__DIR__ );exit;
        return $resolver->resolve(__DIR__ . '/../../../Resources/config/routes.yaml', 'yaml')->load(__DIR__ . '/../Resources/config/routes.yaml');
    }
    
  
}
