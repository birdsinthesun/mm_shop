<?php

namespace Bits\MmShopBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Bits\MmShopBundle\EventListener\Backend\MailSubmitListener;

class MailCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(MailSubmitListener::class)) {
            return;
        }

        $definition = $container->getDefinition(MailSubmitListener::class);
        //var_dump(get_class_methods($definition));exit;
        
        $definition->addTag('kernel.event_listener', [
            'event' => 'dc-general.model.pre-persist',
            'priority' => -199])
        ->setPublic(true);
        $container->setDefinition(MailSubmitListener::class, $definition);
        
    }
}
