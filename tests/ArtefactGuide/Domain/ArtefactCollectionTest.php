<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\ArtefactGuide\Domain;

use Cbase\ArtefactGuide\Domain\Artefact;
use Cbase\ArtefactGuide\Domain\ArtefactCollection;
use Cbase\ArtefactGuide\Domain\Image;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class ArtefactCollectionTest extends UnitTestCase
{
    public function test_an_artefact_collection_can_be_created(): void
    {
        $artefactCollection = ArtefactCollection::create();

        self::assertInstanceOf(ArtefactCollection::class, $artefactCollection);
        self::assertCount(0, $artefactCollection);
    }

    public function test_artefacts_can_be_added_during_creation_of_collection(): void
    {
        $artefactCollection = ArtefactCollection::create([new Artefact()]);

        self::assertCount(1, $artefactCollection);
    }

    public function test_artefacts_can_be_added_to_collection(): void
    {
        $artefactCollection = ArtefactCollection::create();

        $artefactCollection->append(new Artefact());

        self::assertEquals(1, $artefactCollection->count());
    }

    public function test_collection_can_only_be_created_with_artifacts(): void
    {
        self::expectException(\InvalidArgumentException::class);
        $artefactCollection = ArtefactCollection::create([new Image()]);

        self::assertEquals(0, $artefactCollection->count());
    }

    public function test_only_artifacts_can_be_added(): void
    {
        self::expectException(\InvalidArgumentException::class);
        $artefactCollection = ArtefactCollection::create();
        $artefactCollection->append(new Image());

        self::assertEquals(0, $artefactCollection->count());
    }
}
