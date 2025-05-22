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
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Bits\MmShopBundle\Service\ResourceResolver;
use Doctrine\DBAL\Connection;


class ProductListController extends AbstractController
{

    public function __construct(
        private Connection $db,
        private ResourceResolver $resourceResolver,
        private readonly ContaoFramework $framework
    ) {
       
        $this->resourceResolver = $resourceResolver;
        }
    public function runRoot(Request $request): Response
    {
        $this->framework->initialize();
         

        global $objPage;
        $pageId = $this->db->fetchFirstColumn(
                'SELECT product_list_page FROM mm_shop WHERE id = ?', 
                ['1']);
        $objPage = PageModel::findPublishedById($pageId[0]);
        $request->attributes->set('pageModel', $objPage);
        $objPage->__set('layout','27');

        if (!$objPage) {
            throw new \RuntimeException('Produktseite nicht gefunden.');
        }

        // Übergib die Seite an Contao's regulären Renderer
        $controller = new PageRegular();
        //var_dump($pageId,'test');exit;
        return $controller->getResponse($objPage, false);
    }
    
    public function runCategory(Request $request, string $category): Response
    {
        $this->framework->initialize();
        
        if (!$this->resourceResolver->hasCategoryProducts($category)|| !$this->resourceResolver->isProductCategory($category)){
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        global $objPage;
         $pageId = $this->db->fetchFirstColumn(
                'SELECT product_list_page FROM mm_shop WHERE id = ?', 
                ['1']);
        $objPage = PageModel::findPublishedById($pageId[0]);
        $request->attributes->set('pageModel', $objPage);
        $objPage->__set('layout','27');

        if (!$objPage) {
            throw new \RuntimeException('Produktseite nicht gefunden.');
        }

        // Übergib die Seite an Contao's regulären Renderer
        $controller = new PageRegular();
        return $controller->getResponse($objPage, false);
    }
}
