<?php

namespace App\Listener;

use App\Entity\Band;
use App\Service\SeoFactory;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment as TwigEnvironment;

#[AsEventListener(
    event: KernelEvents::CONTROLLER_ARGUMENTS,
    method: 'onControllerArguments'
)]
final readonly class SeoListener
{
    public function __construct(
        private SeoFactory      $seoFactory,
        private TwigEnvironment $twig,
    )
    {
    }

    public function onControllerArguments(ControllerArgumentsEvent $event): void
    {
        $request = $event->getRequest();
        $routeName = $request->attributes->get('_route', '');
        $seo = [];

        if ($routeName && !str_starts_with($routeName, 'admin_')) {
            foreach ($event->getArguments() as $arg) {
                if ($arg instanceof Band) {
                    $band = $arg;
                    break;
                }
            }

            $seo = $this->seoFactory->createForRequest($request, $routeName, $band ?? null);
        }

        $this->twig->addGlobal('seo', $seo);
    }
}
