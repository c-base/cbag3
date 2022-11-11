<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Action\ListArtefacts;

use Cbase\ArtefactGuide\Domain\ArtefactCollection;
use Cbase\ArtefactGuide\Domain\ArtefactRepository;

final class ListArtefactsHandler
{
    public function __construct(private ArtefactRepository $artefactRepository)
    {
    }

    public function __invoke(ListArtefactsQuery $query): ArtefactCollection
    {
        return $this->artefactRepository->all();
    }
}
