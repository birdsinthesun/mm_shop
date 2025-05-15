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
            
                    $GLOBALS['TL_CSS'][] = 'bundles/mmshop/css/products.css';
                    $GLOBALS['TL_CSS'][] = 'bundles/mmshop/css/personal-data.css';
                }
        }else{
            
            //ToDo: $page = PageModel::findOneBy('id',$event->getRequest()->get('id'));
            if(str_contains($event->getRequest()->getPathInfo(),'bestellprozess')){
          
                $connection = System::getContainer()->get('database_connection');  
                $useCustomCss = $connection->fetchAllAssociative(
                'SELECT use_custom_css FROM mm_shop WHERE id = ?', 
                ['1']);
                
                if($useCustomCss === false){
                    
                    $GLOBALS['TL_CSS'][] = 'bundles/mmshop/css/ordering-process.css';
                }
                
            }
            
        }
       
       
        
    }
}