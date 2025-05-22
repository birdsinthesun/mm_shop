<?php
namespace Bits\MmShopBundle\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Response;
use Bits\MmShopBundle\Controller\ProductListController;
use Doctrine\DBAL\Connection;

class KernelRequestListener
{
    private ProductListController $controller;
    private Connection $connection;

    public function __construct(ProductListController $controller, Connection $connection)
    {
        $this->controller = $controller;
        $this->connection = $connection;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        
        $response = $this->controller->runRoot($request);
        $event->setResponse($response);
        return;
        $path = trim($request->getPathInfo(), '/'); // z.B. "produkte/kategorie-2.html"

        // Hol Kategorien aus DB
        $categories = $this->connection->fetchFirstColumn('SELECT alias FROM mm_category WHERE published = 1');

        // Prüfe, ob URL mit "produkte" beginnt
        if (str_starts_with($path, 'produkte')) {
            // Entferne "produkte/" aus dem Pfad
           // $subPath = substr($path, strlen('produkte/'));
            
           
            // Prüfe, ob die URL eine Kategorie enthält (z.B. "kategorie-2.html" oder "kategorie-2")
//            foreach ($categories as $category) {
//                    // Controller aufrufen, Kategorie mitgeben
//                    $response = $this->controller->run($request, $category);
//                    
//
//                    return; // Weiter Routing stoppen
//                
//            }

            // Optional: Wenn keine Kategorie passt, kannst du hier 404 werfen oder nichts tun
        }
    }
}
