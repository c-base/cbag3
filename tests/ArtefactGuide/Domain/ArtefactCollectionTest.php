<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\ArtefactGuide\Domain;

use ArtefactGuide\Domain\Artefact;
use ArtefactGuide\Domain\ArtefactCollection;
use ArtefactGuide\Domain\Image;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class ArtefactCollectionTest extends UnitTestCase
{
    public function test_an_artefact_collection_can_be_created(): void
    {
        $artefactCollection = new ArtefactCollection();

        self::assertInstanceOf(ArtefactCollection::class, $artefactCollection);
        self::assertEquals(0, $artefactCollection->count());
    }

    public function test_artefacts_can_be_added_during_creation_of_collection(): void
    {
        $artefactCollection = new ArtefactCollection([new Artefact()]);

        self::assertEquals(1, $artefactCollection->count());
    }

    public function test_artefacts_can_be_added_to_collection(): void
    {
        $artefactCollection = new ArtefactCollection();

        $artefactCollection->add(new Artefact());

        self::assertEquals(1, $artefactCollection->count());
    }

    public function test_only_artefacts_can_be_added(): void
    {
        $artefactCollection = new ArtefactCollection([new Image(), new \stdClass()]);
        $artefactCollection->add(new Image());

        self::assertEquals(0, $artefactCollection->count());
    }
}
