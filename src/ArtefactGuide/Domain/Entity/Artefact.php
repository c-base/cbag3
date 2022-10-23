<?php

namespace ArtefactGuide\Domain\Entity;

use ArtefactGuide\Infrastructure\Repository\ArtefactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtefactRepository::class)
 */
final class Artefact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @phpstan-ignore-next-line
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    private string $cName;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    private string $slug;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private \DateTime $createdAt;

    /**
     * @var string
     * @ORM\Column(type="string", length=32)
     */
    private string $createdBy;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity=Asset::class, mappedBy="artefact", orphanRemoval=true)
     */
    private Collection $assets;

    public function __construct()
    {
        $this->assets = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCName(): string
    {
        return $this->cName;
    }

    public function setCName(string $cName): Artefact
    {
        $this->cName = $cName;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug($slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return Collection|Asset[]
     */
    public function getAssets(): Collection
    {
        return $this->assets;
    }

    public function addAsset(Asset $asset): self
    {
        if (!$this->assets->contains($asset)) {
            $this->assets[] = $asset;
            $asset->setArtefact($this);
        }

        return $this;
    }

    public function removeAsset(Asset $asset): self
    {
        if ($this->assets->removeElement($asset)) {
            // set the owning side to null (unless already changed)
            if ($asset->getArtefact() === $this) {
                $asset->setArtefact(null);
            }
        }

        return $this;
    }
}
