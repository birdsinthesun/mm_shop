<?php

namespace Bits\MmShopBundle\EventListener\Product;


use ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\PaletteInterface;

use ContaoCommunityAlliance\DcGeneral\Factory\Event\BuildDataDefinitionEvent;


class DefaulValueCardCount

{

    public function __invoke(BuildDataDefinitionEvent $event): void

    {

        // Get container.

        $container = $event->getContainer();

        // Check right table present.

        if ('mm_product' !== $container->getName()) {

            return;

        }

        // Set default value.

        $container->getPropertiesDefinition()->getProperty('card_count')->setDefaultValue('7');

    }

}