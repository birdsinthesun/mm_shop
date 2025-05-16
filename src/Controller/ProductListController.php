<?php

namespace Bits\MmShopBundle\Controller;

use Contao\CoreBundle\Controller\FrontendController;
use Contao\PageModel;
use Contao\PageRegular;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductListController
{
    public function run(string $alias): Response
    {
        // Produkt über Alias finden (z. B. aus MetaModels)
        $product = true; // z. B. über Model oder Repository

        if (!$product) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        // Hole die Contao-Detailseite (z. B. aus JumpTo-Spalte)
        $page = PageModel::findByPk('192');

        if (!$page) {
            throw new \RuntimeException('Seite nicht gefunden.');
        }

        // Setze ggf. Contao-GET-Parameter für Nutzung in Modulen/Templates
        $_GET['auto_item'] = $alias;

        // Übergib die Seite an Contao's regulären Renderer
        $controller = new PageRegular();
        return $controller->getResponse($page, true);
    }
}
