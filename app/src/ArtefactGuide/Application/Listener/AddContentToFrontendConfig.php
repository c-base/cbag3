<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Listener;

use Cbase\ArtefactGuide\Domain\Licence;
use Cbase\Shared\Domain\FrontendConfig;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

#[AsEventListener]
final class AddContentToFrontendConfig
{
    public function __construct(private FrontendConfig $config)
    {
    }

    public function __invoke(ControllerEvent $event): void
    {
        $this->config['content'] = ['licences' => Licence::VALID_LICENCES];
    }
}
