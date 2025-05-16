<?php

namespace Bits\MmShopBundle\Routing;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\Loader\Loader;

class DynamicRouteLoader extends Loader
{
    private bool $loaded = false;

    public function load($resource, string $type = null): RouteCollection
    {
        if ($this->loaded) {
            throw new \RuntimeException('Do not load this loader twice.');
        }

        $routes = new RouteCollection();
        $rootPageAlias = 'produkte';
        $categories = ['kategorie-1', 'kategorie-2']; // z. B. aus DB oder Config

        foreach ($categories as $category) {
            
            $routeList = new Route(
                '/'.$rootPageAlias.'/' . $category .'.html',
                [
                    '_controller' => 'Bits\\MmShopBundle\\Controller\\ProductListController::run',
                    'scheme' => 'https',
                    'category' => $category,
                    'type' => 'dynamic'
                ],
                ['alias' => '.+']
            );
            $routes->add('mm_product_list_' . $category, $routeList);
            
            
            
            
            $routeDetails = new Route(
                '/'.$rootPageAlias.'/' . $category . '/{alias}',
                [
                    '_controller' => 'Bits\\MmShopBundle\\Controller\\ProductDetailController::run',
                    'scheme' => 'https',
                    'category' => $category,
                    'type' => 'dynamic'
                ],
                ['alias' => '.+']
            );
            $routes->add('mm_product_detail_' . $category, $routeDetail);
        }

        $this->loaded = true;

        return $routes;
    }

    public function supports($resource, string $type = Null): bool
    {
        return 'dynamic' === $type;
    }
}
