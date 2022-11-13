<?php

declare(strict_types=1);

namespace Tests\ArtefactGuide\Domain;

use Tests\Factory\ArtefactGuide\ArtefactFactory;
use Tests\Factory\ArtefactGuide\ImageFactory;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class ArtefactTest extends UnitTestCase
{
    public function test_artefact_is_serializable(): void
    {
        $artefact = ArtefactFactory::create();
        $artefact->addImage(ImageFactory::create());

        $serialized = $artefact->jsonSerialize();

        self::assertIsArray($serialized);
        self::assertArrayHasKey('images', $serialized);
        self::assertIsArray($serialized['images']);
    }
}
