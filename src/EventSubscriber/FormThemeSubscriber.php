<?php

namespace Bits\MmShopBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class FormThemeSubscriber implements EventSubscriberInterface
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $themes = $this->twig->getGlobals()['form_themes'] ?? [];
        if (!in_array('@MmShop/form/fields.html.twig', $themes, true)) {
            $themes[] = '@MmShop/form/fields.html.twig';
            $this->twig->addGlobal('form_themes', $themes);
        }
    }
}
