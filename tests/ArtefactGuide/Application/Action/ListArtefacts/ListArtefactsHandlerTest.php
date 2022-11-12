<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\ArtefactGuide\Application\Action\ListArtefacts;

use Cbase\ArtefactGuide\Application\Action\ListArtefacts\ListArtefactsHandler;
use Cbase\ArtefactGuide\Application\Action\ListArtefacts\ListArtefactsQuery;
use Cbase\ArtefactGuide\Domain\ArtefactCollection;
use Cbase\ArtefactGuide\Domain\ArtefactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Nyholm\NSA;
use Tests\Factory\ArtefactGuide\ArtefactFactory;
use Tests\Factory\ArtefactGuide\ImageFactory;
use Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;

final class ListArtefactsHandlerTest extends InfrastructureTestCase
{
    public function test_we_get_empty_collection(): void
    {
        $handler = $this->service(ListArtefactsHandler::class);
        
        $artefacts = ($handler)(ListArtefactsQuery::create());

        self::assertInstanceOf(ArtefactCollection::class, $artefacts);
        self::assertCount(0, $artefacts);
    }

    public function test_we_get_artefacts_in_collection(): void
    {
        $artefact = ArtefactFactory::create();
        $artefact->addImage(ImageFactory::create());
        $this->service(ArtefactRepository::class)->save($artefact);

        $handler = $this->service(ListArtefactsHandler::class);

        $artefacts = ($handler)(ListArtefactsQuery::create());

        self::assertInstanceOf(ArtefactCollection::class, $artefacts);
        self::assertCount(1, $artefacts);

        self::assertSame($artefact, $artefacts[0]);
    }
}
