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

#[Route(defaults: ['_scope' => 'frontend'])]
class ProductDetailController extends AbstractController
{
    
    public function __construct(
        private Connection $db,
        private ResourceResolver $resourceResolver,
        private readonly ContaoFramework $framework
    ) {
        $this->resourceResolver = $resourceResolver;
        }
    
    public function __invoke(Request $request, string $alias, string $category): Response
    {
        $this->framework->initialize();
      // var_dump($this->resourceResolver->isProduct($category,$alias));exit;
        if (!$this->resourceResolver->isProduct($category,$alias) || !$this->resourceResolver->isProductCategory($category)) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }
 
        global $objPage;
        $objPage = PageModel::findPublishedById('195');
        $request->attributes->set('pageModel', $objPage);

        if (!$objPage) {
            throw new \RuntimeException('Detailseite nicht gefunden.');
        }

        // Übergib die Seite an Contao's regulären Renderer
        $controller = new PageRegular();
        return $controller->getResponse($objPage, false);
    }
}
