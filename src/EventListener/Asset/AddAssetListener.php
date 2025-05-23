<?php

namespace Bits\MmShopBundle\EventListener\Asset;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Contao\System;
use Doctrine\DBAL\Connection;


#[AsEventListener]
class AddAssetListener
{
    private ScopeMatcher $scopeMatcher;

    
    public function __construct(ScopeMatcher $scopeMatcher)
    {
        $this->scopeMatcher = $scopeMatcher;
    }

    public function __invoke(RequestEvent $event): void
    {
        
        if ($this->scopeMatcher->isBackendMainRequest($event)) {
           
             if ($event->getRequest()->getPathInfo() === 'contao/metamodel/mm_product') {
            
                    $GLOBALS['TL_CSS'][] = 'bundles/mmshop/assets/css/products.css';
                    $GLOBALS['TL_CSS'][] = 'bundles/mmshop/assets/css/personal-data.css';
                }
        }else{
            //Style
            $GLOBALS['TL_CSS'][] = 'bundles/mmshop/assets/css/shop.css';
           //Navigation
           $GLOBALS['TL_CSS'][] = 'bundles/mmshop/assets/css/navigation.css';
           $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/mmshop/assets/js/navigation.js';
            //ToDo: $page = PageModel::findOneBy('id',$event->getRequest()->get('id'));
            if(str_contains($event->getRequest()->getPathInfo(),'kasse')){
          
                $connection = System::getContainer()->get('database_connection');  
                $useCustomCss = $connection->fetchAllAssociative(
                'SELECT use_custom_css FROM mm_shop WHERE id = ?', 
                ['1']);
                  
                if($useCustomCss[0]['use_custom_css'] === ''){
                
                    $GLOBALS['TL_CSS'][] = 'bundles/mmshop/assets/css/ordering-process.css';
                }
                
            }
            
        }
       
       
        
    }
}