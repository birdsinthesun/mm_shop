<?php

namespace Bits\MmShopBundle\EventListener\Backend;

use Contao\CoreBundle\Event\ContaoCoreEvents;
use Contao\CoreBundle\Event\MenuEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;


#[AsEventListener(ContaoCoreEvents::BACKEND_MENU_BUILD)]
class MenuListener
{
     public function __invoke(MenuEvent $event): void
    {
        $factory = $event->getFactory();
        $tree = $event->getTree();

        if ('mainMenu' !== $tree->getName()) {
            return;
        }
        $children = $tree->getChildren();
        
        
        $favoritesNode = $tree->getChild('content');

        $node = $factory
            ->createItem('shop')
                ->setLabel('Shop')
                 ->setAttribute('icon', 'bundles/mmshop/icons/shop.svg')
                ->setChildrenAttribute('class', 'group-shop') // CSS-Klasse
        ;

        $favoritesNode->getParent()->addChild($node);
      

        $tree->reorderChildren(
            array_merge(
                ['shop'],
                array_diff(array_keys($children), ['shop'])
            )
        );
         
      }
}
