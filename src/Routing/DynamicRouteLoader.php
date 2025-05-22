<?php

namespace Bits\MmShopBundle\Routing;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\Loader\Loader;
use Bits\MmShopBundle\Controller\ProductDetailController;
use Bits\MmShopBundle\Controller\ProductListController;
use Doctrine\DBAL\Connection;
use Symfony\Component\Routing\RequestContextAwareInterface;
use Symfony\Component\Routing\RequestContext;

class DynamicRouteLoader extends Loader implements RequestContextAwareInterface
{
    private bool $loaded = false;
    private Connection $db; 
    private $context;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }
    
    public function getContext():RequestContext
    {
        return $this->context;
    }
    public function setContext(RequestContext $context)
    {
        $this->context = $context;
    }
    public function load($resource, string $type = null)
    {
        if ($this->loaded) {
            throw new \RuntimeException('Do not load this loader twice.');
        }

        $routes = new RouteCollection();
        $rootPageAlias = 'produkte';
        $sql = "SELECT alias FROM mm_category WHERE published = '1'";
        $categories = $this->db->fetchFirstColumn($sql);
        
        $routeRoot = new Route(
                '/'.$rootPageAlias.'{!parameters}',
                
                [
                    '_controller' => 'Bits\MmShopBundle\Controller\ProductListController::runRoot',
                ],
                [],
                [
                    '_scope' => 'frontend'
                ]
               
                
            );
           // $routeRoot->setSchemes('https');
            $routes->add('mm_product_root', $routeRoot);
        
        foreach ($categories as $key => $category) {
            
            
            $routeList = new Route(
                '/'.$rootPageAlias.'/' . $category.'{!parameters}',
                [
                    '_controller' => 'Bits\MmShopBundle\Controller\ProductListController::runCategory',
                    'category' => $category,
                ],
                [],
                [
                    '_scope' => 'frontend'
                ]
            );
            //$routeList->setSchemes('https');
            $routes->add('mm_product_list_' . $category, $routeList);
            
            
            
            
            $routeDetail = new Route(
                '/'.$rootPageAlias.'/' . $category . '/{alias}{!parameters}',
                [
                    '_controller' => 'Bits\MmShopBundle\Controller\ProductDetailController::run',
                    'category' => $category,
                ],
                ['alias' => '.+'],
                [
                    '_scope' => 'frontend'
                ]
            );
           // $routeDetail->setSchemes('https');
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
