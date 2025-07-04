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
    private Connection $db;
    
    private ScopeMatcher $scopeMatcher;
    
    public function __construct(Connection $db,ScopeMatcher $scopeMatcher)
    {
        $this->scopeMatcher = $scopeMatcher;
        $this->db = $db;
    }

    public function __invoke(RequestEvent $event): void
    {
        
        if ($this->scopeMatcher->isBackendMainRequest($event)) {
           
            $GLOBALS['TL_CSS'][] = 'bundles/mmshop/assets/css/backend/shop.css';
           
             if ($event->getRequest()->getPathInfo() === '/contao/metamodel/mm_product') {
            
                    $GLOBALS['TL_CSS'][] = 'bundles/mmshop/assets/css/backend/products.css';
            
                }
        }else{
            $useCustomCss = $this->db->fetchAssociative(
                'SELECT use_custom_css FROM mm_shop WHERE id = ?', 
                ['1']);
            if(is_array($useCustomCss)&&$useCustomCss['use_custom_css'] === ''){
            
            //Product Pages
            $GLOBALS['TL_CSS'][] = 'bundles/mmshop/assets/css/products.css';
           //Navigation
           $GLOBALS['TL_CSS'][] = 'bundles/mmshop/assets/css/navigation.css';
           $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/mmshop/assets/js/navigation.js';
            //ToDo: $page = PageModel::findOneBy('id',$event->getRequest()->get('id'));
            if(str_contains($event->getRequest()->getPathInfo(),'kasse')){
                    $GLOBALS['TL_CSS'][] = 'bundles/mmshop/assets/css/ordering-process.css';
                }
                
            }
            
        }
       
       
        
    }
}