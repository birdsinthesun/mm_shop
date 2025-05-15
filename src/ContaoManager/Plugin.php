<?php
namespace Bits\MmShopBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Bits\MmShopBundle\MmShopBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use MetaModels\CoreBundle\MetaModelsCoreBundle; 

class Plugin implements BundlePluginInterface,  RoutingPluginInterface
{
    
  

    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
    {
        return $resolver
            ->resolve(__DIR__.'/../Controller', 'attribute')
            ->load(__DIR__.'/../Controller')
        ;
    }
    
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(MmShopBundle::class)
                ->setLoadAfter([
                    FrameworkBundle::class,
                    TwigBundle::class,
                    ContaoCoreBundle::class,
                    MetaModelsCoreBundle::class
                ]),
        ];
    }
}
