<?php

namespace Bits\MmShopBundle\Controller;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Controller\AbstractController;
use Contao\PageModel;
use Contao\PageRegular;
use Contao\System;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Bits\MmShopBundle\Service\ResourceResolver;
use Doctrine\DBAL\Connection;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


#[Route(defaults: ['_scope' => 'frontend'])]
class ProductController extends AbstractController
{

    public function __construct(
        private Connection $db,
        private ResourceResolver $resourceResolver,
        private readonly ContaoFramework $framework,
        private ParameterBagInterface $params
    ) {
       
        $this->resourceResolver = $resourceResolver;
        }
    public function runRoot(Request $request): Response
    {
        $this->framework->initialize();
         

        global $objPage;
        $shopConfigId = $this->params->get('env(MM_SHOP_CONFIG_DE)');
        $pageId = $this->db->fetchFirstColumn(
                'SELECT product_list_page FROM mm_shop WHERE id = ?', 
                [$shopConfigId]);
        $objPage = PageModel::findPublishedById($pageId[0]);
        $objPage->__set('language','de');
        $request->attributes->set('pageModel', $objPage);

        if (!$objPage) {
            throw new \RuntimeException('Produktseite nicht gefunden.');
        }

        // Übergib die Seite an Contao's regulären Renderer
        $controller = new PageRegular();
      //  var_dump( $objPage,'test');exit;
        return $controller->getResponse($objPage, true);
    }
    
    public function runCategory(Request $request, string $category): Response
    {
        $this->framework->initialize();
        
        if (!$this->resourceResolver->hasCategoryProducts($category)|| !$this->resourceResolver->isProductCategory($category)){
           
            return $this->run404();
          
          //Contao do not handle that at this point
          throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
       }

        global $objPage;
        $shopConfigId = $this->params->get('env(MM_SHOP_CONFIG_DE)');
        $pageId = $this->db->fetchFirstColumn(
                'SELECT product_list_page FROM mm_shop WHERE id = ?', 
                [$shopConfigId]);
        $objPage = PageModel::findPublishedById($pageId[0]);
        $metaDescription = $this->db->fetchFirstColumn(
                'SELECT short_description FROM mm_category WHERE alias = ?', 
                [str_replace('.html','',$category)]);
        $metaDescription = ($metaDescription[0])??'';
        $objPage->__set('description',$metaDescription);
        $objPage->__set('language','de');
        $request->attributes->set('pageModel', $objPage);
        if (!$objPage) {
            throw new \RuntimeException('Produktseite nicht gefunden.');
        }

        // Übergib die Seite an Contao's regulären Renderer
        $controller = new PageRegular();
        return $controller->getResponse($objPage, false);
    }
    
    public function runDetail(Request $request, string $alias, string $category): Response
    {
        $this->framework->initialize();
      if (!$this->resourceResolver->isProduct($category,$alias) || !$this->resourceResolver->isProductCategory($category)) {
            
          return $this->run404();
          
          //Contao do not handle that at this point
          throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

  
        global $objPage;
        $shopConfigId = $this->params->get('env(MM_SHOP_CONFIG_DE)');
        $pageId = $this->db->fetchFirstColumn(
                'SELECT product_detail_page FROM mm_shop WHERE id = ?', 
                [$shopConfigId]);
        $objPage = PageModel::findPublishedById($pageId[0]);
        $metaDescription = $this->db->fetchFirstColumn(
                'SELECT short_description FROM mm_product WHERE alias = ?', 
                [str_replace('.html','',$alias)]);
        $metaDescription = ($metaDescription[0])??'';
        $objPage->__set('description',$metaDescription);
         $objPage->__set('language','de');
        $request->attributes->set('pageModel', $objPage);
        

        if (!$objPage) {
            throw new \RuntimeException('Detailseite nicht gefunden.');
        }

        // Übergib die Seite an Contao's regulären Renderer
        $controller = new PageRegular();
        return $controller->getResponse($objPage, false);
    }
    
    private function run404()
    {
        $obj404 = PageModel::findOneBy(['type=?', 'published=?'], ['error_404', 1]);

            if ($obj404 instanceof PageModel) {
                global $objPage;
                $objPage = $obj404;

                $controller = new \Contao\PageRegular();
                return $controller->getResponse($objPage, true);
            }
        
        
        
        
        }
    public static function getSubscribedServices(): array
    {
        $services = parent::getSubscribedServices();
        
        return $services;
    }

}
