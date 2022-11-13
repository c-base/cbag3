<?php

declare(strict_types=1);

namespace Tests\ArtefactGuide\Infrastructure\PhpUnit;

use Assert\Assert;
use Cbase\ArtefactGuide\Domain\ArtefactRepository;
use Cbase\ArtefactGuide\Domain\ImageRepository;
use Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;

abstract class ArtefactGuideInfrastructureTestCase extends InfrastructureTestCase
{
    protected function artefactRepository(): ArtefactRepository
    {
        return $this->service(ArtefactRepository::class);
    }

    protected function imageRepository(): ImageRepository
    {
        return $this->service(ImageRepository::class);
    }
}
