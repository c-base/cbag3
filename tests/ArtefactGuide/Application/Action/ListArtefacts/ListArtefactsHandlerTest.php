<?php

declare(strict_types=1);

namespace Tests\ArtefactGuide\Application\Action\ListArtefacts;

use Cbase\ArtefactGuide\Application\Action\ListArtefacts\ListArtefactsHandler;
use Cbase\ArtefactGuide\Application\Action\ListArtefacts\ListArtefactsQuery;
use Cbase\ArtefactGuide\Domain\ArtefactCollection;
use Tests\ArtefactGuide\Infrastructure\PhpUnit\ArtefactGuideInfrastructureTestCase;
use Tests\Factory\ArtefactGuide\ArtefactFactory;
use Tests\Factory\ArtefactGuide\ImageFactory;

final class ListArtefactsHandlerTest extends ArtefactGuideInfrastructureTestCase
{
    public function test_we_get_empty_collection(): void
    {
        /** @var ListArtefactsHandler $handler */
        $handler = $this->service(ListArtefactsHandler::class);

        $artefacts = ($handler)(ListArtefactsQuery::create());

        self::assertInstanceOf(ArtefactCollection::class, $artefacts);
        self::assertCount(0, $artefacts);
    }

    public function test_we_get_artefacts_in_collection(): void
    {
        $artefact = ArtefactFactory::create();
        $artefact->addImage(ImageFactory::create());
        $this->artefactRepository()->save($artefact);

        /** @var ListArtefactsHandler $handler */
        $handler = $this->service(ListArtefactsHandler::class);

        $artefacts = ($handler)(ListArtefactsQuery::create());

        self::assertInstanceOf(ArtefactCollection::class, $artefacts);
        self::assertCount(1, $artefacts);

        self::assertSame($artefact, $artefacts[0]);
    }
}
