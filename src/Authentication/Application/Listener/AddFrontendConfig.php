<?php

declare(strict_types=1);

namespace Cbase\Authentication\Application\Listener;

use Cbase\App\Domain\FrontendConfig;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Bundle\SecurityBundle\Security;

#[AsEventListener]
final class AddFrontendConfig
{
    public function __construct(private FrontendConfig $config, private Security $security)
    {
    }

    public function __invoke(ControllerEvent $event)
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

        $this->config->addConfig('auth', $auth);
    }
}
