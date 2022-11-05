<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\Fake\Infrastructure\Doctrine;

use ArtefactGuide\Domain\Artefact;
use ArtefactGuide\Domain\ArtefactCollection;
use ArtefactGuide\Domain\ArtefactRepository;
use Symfony\Contracts\Service\ResetInterface;

final class InMemoryArtefactRepository implements ArtefactRepository, ResetInterface
{
    private ArtefactCollection $artefacts;

    public function __construct()
    {
        $this->artefacts = new ArtefactCollection();
    }

    public function all(): ArtefactCollection
    {
        return $this->artefacts;
    }

    public function save(Artefact $artefact): void
    {
        $this->artefacts->append($artefact);
    }

    public function reset()
    {
        $this->artefacts = new ArtefactCollection();
    }
}
