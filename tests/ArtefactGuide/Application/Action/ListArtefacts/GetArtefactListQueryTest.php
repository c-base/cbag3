<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\ArtefactGuide\Application\Action\ListArtefacts;

use Tests\Factory\ArtefactGuide\ArtefactFactory;
use Tests\Factory\ArtefactGuide\ImageFactory;
use Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;

final class GetArtefactListQueryTest extends InfrastructureTestCase
{
    public function test_we_can_serialize_the_artefacts()
    {
        $artefact = ArtefactFactory::create();
        $artefact->addImage(ImageFactory::create());

        $result = $artefact->normalize();
        dd($result);
    }


}
