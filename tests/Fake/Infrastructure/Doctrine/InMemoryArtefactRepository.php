<?php

declare(strict_types=1);

namespace Tests\Fake\Infrastructure\Doctrine;

use Cbase\ArtefactGuide\Domain\Artefact;
use Cbase\ArtefactGuide\Domain\ArtefactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Nyholm\NSA;
use Symfony\Contracts\Service\ResetInterface;

final class InMemoryArtefactRepository implements ArtefactRepository, ResetInterface
{
    /**
     * @var ArrayCollection<int, Artefact>
     */
    private ArrayCollection $artefacts;

    public function __construct()
    {
        $this->artefacts = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function all(): array
    {
        return $this->artefacts->toArray();
    }

    public function save(Artefact $artefact): void
    {
        $this->artefacts->add($artefact);
    }

    public function reset(): void
    {
        $this->artefacts = new ArrayCollection();
    }

    public function getBySlug(string $slug): Artefact
    {
        foreach ($this->artefacts as $artefact) {
            if (NSA::getProperty($artefact, 'slug')->value() === $slug) {
                return $artefact;
            }
        }
        throw new \Exception("No artefact found for slug \"{$slug}\"");
    }
}
