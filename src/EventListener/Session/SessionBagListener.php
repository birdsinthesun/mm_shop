<?php

namespace Bits\MmShopBundle\EventListener\Session;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Bits\MmShopBundle\Session\CartSessionBag;

class SessionBagListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!$request->hasSession()) {
            return;
        }

        /** @var SessionInterface $session */
        $session = $request->getSession();

        try {
            $session->getBag('cart');
        } catch (\InvalidArgumentException) {
            $session->registerBag(new CartSessionBag());
        }
    }
}
