<?php

declare(strict_types=1);

namespace Cbase\Authentication\Application\Listener;

use Cbase\Shared\Domain\FrontendConfig;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

#[AsEventListener]
final class AddAuthToFrontendConfig
{
    public function __construct(private FrontendConfig $config, private Security $security)
    {
    }

    public function __invoke(ControllerEvent $event): void
    {
        $auth = [
            'authenticated' => false,
        ];

        if ($this->security->getUser()) {
            $auth = [
                'authenticated' => true,
                'username' => $this->security->getUser()->getUserIdentifier(),
            ];
        }

        $this->config['auth'] = $auth;
    }
}
