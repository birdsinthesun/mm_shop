<?php
use Contao\CoreBundle\ContaoCoreBundle;

use Bits\FlyUxBundle\Pages\MyPageRegular;
use Bits\FlyUxBundle\Content\Plus\ContentContentSlider;
use Bits\FlyUxBundle\Content\Plus\ContentGrid;
use Bits\FlyUxBundle\Driver\DC_Content;
use Bits\FlyUxBundle\Widgets\ModuleWizard;
use Bits\FlyUxBundle\Content\ContentModule;


    $GLOBALS['TL_PTY']['regular'] = MyPageRegular::class;
    $GLOBALS['BE_FFL']['flyWizard']  = ModuleWizard::class;
    $GLOBALS['TL_CTE']['includes']['module'] = ContentModule::class;
    $GLOBALS['TL_CTE']['plus']['contentslider'] = ContentContentSlider::class;
    $GLOBALS['TL_CTE']['plus']['contentgrid'] = ContentGrid::class;
  
    $GLOBALS['TL_DCA']['tl_content']['config']['dataContainer'] = DC_Content::class;
                   
    $GLOBALS['BE_MOD']['content']['page']['tables'] = ['tl_page','tl_content'];
    $GLOBALS['BE_FLY_UX']['content']['page']['config']  = [
                  'driver' => 'fly_ux',
                  'relations' => [
                    'tl_page', 
                    'tl_content'
                        ],
                  'callbacks' => [
                    'view_settings' => ['Bits\FlyUxBundle\EventListener\View\ContentLayoutModeContentListener', 'getSettings']
                  
                  ]
    ];
    $GLOBALS['BE_MOD']['content']['content']['tables'] = ['tl_content'];
    $GLOBALS['BE_FLY_UX']['content']['content']['config'] = [ 
                  'driver' => 'fly_ux',
                  'relations' => [
                    'tl_page', 
                    'tl_content'
                        ],
                  'callbacks' => [
                    'view_settings' => ['Bits\FlyUxBundle\EventListener\View\ContentLayoutModeContentListener', 'getSettings']
                  
                  ]
  ];
    $GLOBALS['BE_FLY_UX']['content']['calendar']['config']  = [
                'driver' => 'fly_ux',
                'relations' => [
                    'tl_calendar', 
                    'tl_calendar_events',
                    'tl_content'
                        ],
                  'callbacks' => [
                    'view_settings' => ['Bits\FlyUxBundle\EventListener\View\ContentLayoutModeCalendarListener', 'getSettings']
                  
                  ]
  ];
    $GLOBALS['BE_FLY_UX']['content']['news']['config']  = [
                 'driver' => 'fly_ux',
                'relations' => [
                    'tl_news_archive',
                    'tl_news', 
                    'tl_content'
                        ],
                  'callbacks' => [
                    'view_settings' => ['Bits\FlyUxBundle\EventListener\View\ContentLayoutModeNewsListener', 'getSettings']
                  
                  ]
  ];
  
        unset($GLOBALS['BE_MOD']['content']['article']);
        unset($GLOBALS['FE_MOD']['navigationMenu']['articlenav']);
        unset($GLOBALS['FE_MOD']['miscellaneous']['articlelist']);
        unset($GLOBALS['TL_CTE']['includes']['article']);
        //unset($GLOBALS['TL_CTE']['includes']['content']);
        unset($GLOBALS['TL_CTE']['includes']['teaser']);
        unset($GLOBALS['TL_CTE']['includes']['alias']);
        unset($GLOBALS['TL_CTE']['legacy']['accordionSingle']);
        unset($GLOBALS['TL_CTE']['miscellaneous']['swiper']);
         unset($GLOBALS['TL_CTE']['miscellaneous']['element_group']);
        //unset($GLOBALS['TL_MODELS']['tl_article']);
         // unset($GLOBALS['TL_DCA']['tl_page']['list']['operations']['children']);
       
              