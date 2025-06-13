<?php

$GLOBALS['TL_DCA']['tl_module']['fields']['mms_use_for_mobile'] = [	
            'inputType'               => 'checkbox',
			'eval'                    => ['tl_class'=>'w25 clr'],
			'sql'                     => ['type' => 'boolean', 'default' => false],
	];
$GLOBALS['TL_DCA']['tl_module']['palettes']['product_navigation'] =  '{title_legend},name,type,mms_use_for_mobile';