<?php
$GLOBALS['TL_DCA']['tl_page']['fields']['mm_shop_config'] = [
                'inputType' => 'select',
                'foreignKey' => 'mm_shop.name',
                'eval' => ['chosen' => true, 'mandatory' => true,'multiple' => false, 'tl_class' => 'w50'],
                'sql' => "int(10) unsigned NOT NULL default 0",
            ];
$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] = str_replace('{routing_legend}','{mmshop_legend},mm_shop_config;{routing_legend}',$GLOBALS['TL_DCA']['tl_page']['palettes']['root']);
$GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'] = str_replace('{routing_legend}','{mmshop_legend},mm_shop_config;{routing_legend}',$GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback']);

