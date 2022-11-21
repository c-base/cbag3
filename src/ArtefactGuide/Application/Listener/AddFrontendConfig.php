<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Listener;

use Cbase\App\Domain\FrontendConfig;
use Cbase\ArtefactGuide\Domain\Licence;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

#[AsEventListener]
final class AddFrontendConfig
{
    public function __construct(private FrontendConfig $config)
    {
    }

    public function __invoke(ControllerEvent $event)
    {
        $this->config->addConfig('content', ['licences' => Licence::VALID_LICENCES]);
    }
}
