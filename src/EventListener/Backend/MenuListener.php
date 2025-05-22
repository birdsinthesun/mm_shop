<?php

namespace Bits\MmShopBundle\EventListener\Backend;

use Contao\CoreBundle\Event\ContaoCoreEvents;
use Contao\CoreBundle\Event\MenuEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;


#[AsEventListener(event: ContaoCoreEvents::BACKEND_MENU_BUILD, priority: 10)]
class MenuListener
{
     public function __invoke(MenuEvent $event): void
    {
        $factory = $event->getFactory();
        $tree = $event->getTree();

        if ('mainMenu' !== $tree->getName()) {
            return;
        }
        
        
        
        $favoritesNode = $tree->getChild('content');
//var_dump(get_class_methods( $factory->createItem('shop')));exit;
        $node = $factory
            ->createItem('shop')
                ->setUri('/contao?mtg=shop')
                ->setName('shop')
                ->setLabel('Shop')
                ->setLinkAttribute('data-action',"contao--toggle-navigation#toggle:prevent")
                ->setLinkAttribute('data-contao--toggle-navigation-category-param','shop')
                ->setLinkAttribute('contao--toggle-navigation#toggle:prevent','shop')
                ->setLinkAttribute('aria-controls','shop')
               ->setLinkAttribute('aria-expanded','true')
                 ->setLinkAttribute('icon', 'bundles/mmshop/icons/shop.svg')
                ->setLinkAttribute('class', 'group-shop')
                 ->setLinkAttribute('title', 'Bereich schließen')
        ;

        $favoritesNode->getParent()->addChild($node);
        $children = $tree->getChildren();

        $tree->reorderChildren(
            array_merge(
                ['shop'],
                array_diff(array_keys($children), ['shop'])
            )
        );
         
      }
}
