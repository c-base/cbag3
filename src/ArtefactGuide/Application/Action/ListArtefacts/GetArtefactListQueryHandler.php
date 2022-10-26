<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace ArtefactGuide\Application\Action\ListArtefacts;

use ArtefactGuide\Domain\ArtefactCollection;
use ArtefactGuide\Domain\ArtefactRepository;

final class GetArtefactListQueryHandler
{
    public function __construct(private readonly ArtefactRepository $artefactRepository)
    {
    }

    public function __invoke(): ArtefactCollection
    {
        return $this->artefactRepository->all();
    }
}
