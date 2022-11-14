<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Application\Action\UpdateArtefact;

final class UpdateArtefactCommand
{
    public string $id;
    public array $artefact;
}
