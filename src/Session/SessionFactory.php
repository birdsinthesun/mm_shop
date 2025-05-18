<?php

namespace Bits\MmShopBundle\Session;

use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionFactoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionFactory implements SessionFactoryInterface
{
    public function __construct(
        private readonly SessionFactoryInterface $inner,
        private readonly SessionBagInterface $cartBag
    ) {}

    public function createSession(): SessionInterface
    {
        $session = $this->inner->createSession();
        $session->registerBag($this->cartBag);
        return $session;
    }
}
