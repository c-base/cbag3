<?php
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
        return ArtefactCollection::create($this->artefactRepository->all());
    }
}
