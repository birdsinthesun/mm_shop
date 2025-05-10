<?php

use Contao\Backend;
use Contao\System;
use Contao\StringUtil;


$GLOBALS['TL_DCA']['tl_files']['config']['dataContainer'] = 'Bits\FlyUxBundle\Driver\DC_Media';
$GLOBALS['TL_DCA']['tl_files']['list']['global_operations']['media_view'] = [
    'href'  => 'do=files&view=media',
    'class' => 'header_media_view',
    'label' => ['Medienansicht', 'Nur Bilder anzeigen'],
    //'button_callback'     => array('tl_files_fly_ux', 'switchView')
];
$GLOBALS['TL_DCA']['tl_files']['list']['global_operations']['list_view'] = [
    'href'  => 'do=files&view=list',
    'class' => 'header_list_view',
    'label' => ['Listenansicht', 'Alle Dateien anzeigen'],
    //'button_callback'     => array('tl_files_fly_ux', 'switchView')
];
