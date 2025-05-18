<?php

namespace Bits\MmShopBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Bits\MmShopBundle\Session\SessionFactory;
use Bits\MmShopBundle\Session\CartSessionBag;

class SessionCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(SessionFactory::class)) {
         
        return;}
             
            
            $definition1 = $container->getDefinition(CartSessionBag::class);
           
            $definition1
            ->setPublic(true)
                 ;
            $container->setDefinition(CartSessionBag::class, $definition1);


            $definition = $container->getDefinition(SessionFactory::class);
      //  var_dump(get_class_methods($definition));exit;
            $definition
            ->setClass('Bits\MmShopBundle\Session\SessionFactory', SessionFactory::class)
            ->setDecoratedService('session.factory')
            ->setArguments([new Reference('Bits\MmShopBundle\Session\SessionFactory.inner'),
                new Reference('Bits\MmShopBundle\Session\CartSessionBag')])
            ->setPublic(true)
            ;
            $container->setDefinition(SessionFactory::class, $definition);
           
    
    }
}
