<?php
declare(strict_types=1);

namespace Tests\ArtefactGuide\Infrastructure\Persistence;

use Cbase\ArtefactGuide\Domain\Artefact;
use Tests\ArtefactGuide\Infrastructure\ArtefactGuideInfrastructureTestCase;
use Tests\Factory\ArtefactGuide\ArtefactFactory;

final class ArtefactRepositoryTest extends ArtefactGuideInfrastructureTestCase
{
    public function test_it_should_return_a_saved_artefact(): void
    {
        $artefact = ArtefactFactory::create();

        $this->artefactRepository()->save($artefact);

        $artefacts = $this->artefactRepository()->all();

        self::assertCount(1, $artefacts);
        self::assertEquals($artefact, $artefacts[0]);
    }
}
