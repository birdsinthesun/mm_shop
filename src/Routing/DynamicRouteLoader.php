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
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DynamicRouteLoader extends Loader implements RequestContextAwareInterface
{
    private bool $loaded = false;
    private Connection $db; 
    private $context;
    private ParameterBagInterface $params;

    public function __construct(Connection $db)
    {
        $this->db = $db;
        $this->params = $params;
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
        if(!$this->tableExists('mm_shop')){
            return;
            }
        $shopConfigId = $this->params->get('env(MM_SHOP_CONFIG_DE)');
        $routes = new RouteCollection();
        $rootPageId = $this->db->fetchFirstColumn('SELECT product_list_page FROM mm_shop WHERE id = ?',[$shopConfigId]);
         if(!$rootPageId){
            return;
            }
        $rootPageAlias = $this->db->fetchFirstColumn('SELECT alias FROM tl_page WHERE id = ?',[$rootPageId[0]]);
        $sql = "SELECT alias FROM mm_category WHERE published = '1'";
        $categories = $this->db->fetchFirstColumn($sql);
        
        $routeRoot = new Route(
                '/'.$rootPageAlias[0].'{!parameters}',
                
                [
                    '_controller' => 'Bits\MmShopBundle\Controller\ProductController::runRoot',
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
                '/'.$rootPageAlias[0].'/' . $category.'{!parameters}',
                [
                    '_controller' => 'Bits\MmShopBundle\Controller\ProductController::runCategory',
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
                '/'.$rootPageAlias[0].'/' . $category . '/{alias}{!parameters}',
                [
                    '_controller' => 'Bits\MmShopBundle\Controller\ProductController::runDetail',
                    'category' => $category,
                ],
                [
                'alias' => '[^/]+\\.html',
                'parameters' => '.*'
                ],
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
    
     private function tableExists(string $table): bool
    {
        $schemaManager = method_exists($this->db, 'createSchemaManager')
            ? $this->db->createSchemaManager()
            : $this->db->getSchemaManager();

        return $schemaManager->tablesExist([$table]);
    }
}
