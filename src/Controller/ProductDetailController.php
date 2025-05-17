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


class ProductDetailController extends AbstractController
{

    public function __construct(
        private readonly ContaoFramework $framework
    ) {}
    
    public function __invoke(Request $request, string $alias, string $category): Response
    {
        $this->framework->initialize();
        
        // Produkt über Alias finden (z. B. aus MetaModels)
        $product = true; // z. B. über Model oder Repository

        if (!$product) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        // Hole die Contao-Detailseite (z. B. aus JumpTo-Spalte)
        global $objPage;
        $objPage = PageModel::findPublishedById('195');
        $request->attributes->set('pageModel', $objPage);
//var_dump($page);exit;
        if (!$objPage) {
            throw new \RuntimeException('Detailseite nicht gefunden.');
        }

        // Setze ggf. Contao-GET-Parameter für Nutzung in Modulen/Templates
        $_GET['auto_item'] = $alias;

        // Übergib die Seite an Contao's regulären Renderer
        $controller = new PageRegular();
        return $controller->getResponse($objPage, false);
    }
}
