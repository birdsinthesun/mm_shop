<?php
use Bits\MmShopBundle\Module\OrderingProcessModule;
use Bits\MmShopBundle\Module\CartModule;
use Bits\MmShopBundle\Module\ProductListModule;
use Bits\MmShopBundle\Module\ProductDetailModule;
use Bits\MmShopBundle\Module\NavigationModule;
                

$GLOBALS['FE_MOD']['mm_shop']['ordering_process'] = OrderingProcessModule::class;
$GLOBALS['FE_MOD']['mm_shop']['cart'] = CartModule::class;
$GLOBALS['FE_MOD']['mm_shop']['product_list'] = ProductListModule::class;
$GLOBALS['FE_MOD']['mm_shop']['product_detail'] = ProductDetailModule::class;
$GLOBALS['FE_MOD']['mm_shop']['product_navigation'] = NavigationModule::class;
  