<?php

declare(strict_types=1);

namespace Tests\Shared\Domain;

use Cbase\ArtefactGuide\Domain\Artefact;
use Cbase\ArtefactGuide\Domain\ArtefactCollection;
use Tests\Factory\ArtefactGuide\ArtefactFactory;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class CollectionTest extends UnitTestCase
{
    public function test_collection_can_be_serialized(): void
    {
        $collection = ArtefactCollection::create([
            ArtefactFactory::create(),
        ]);
        $result = $collection->jsonSerialize();

        self::assertIsArray($result);
        self::assertCount(1, $result);
        self::assertInstanceOf(Artefact::class, $result[0]);
    }
}
