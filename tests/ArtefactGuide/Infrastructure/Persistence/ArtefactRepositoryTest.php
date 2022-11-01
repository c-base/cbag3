<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\ArtefactGuide\Infrastructure\Persistence;

use Cbase\ArtefactGuide\Domain\Artefact;
use Cbase\ArtefactGuide\Domain\ArtefactCollection;
use Tests\ArtefactGuide\Infrastructure\ArtefactGuideInfrastructureTestCase;
use Tests\Factory\ArtefactGuide\ArtefactFactory;

final class ArtefactRepositoryTest extends ArtefactGuideInfrastructureTestCase
{
    public function test_it_should_return_a_saved_artefact(): void
    {
        $artefact = ArtefactFactory::create();

        $this->repository()->save($artefact);

        $artefacts = $this->repository()->all();

        self::assertInstanceOf(ArtefactCollection::class, $artefacts);
        self::assertCount(1, $artefacts);

        $actualArtefact = $artefacts->offsetGet(0);

        self::assertInstanceOf(Artefact::class, $artefact);
        self::assertEquals($artefact, $actualArtefact);
    }
}
