<?php

namespace App\Entity;

use App\Repository\ArtefactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtefactRepository", repositoryClass=ArtefactRepository::class)
 */
class Artefact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     * @ORM\Column
     */
    private $createdBy;

    /**
     * @var Asset[]
     * @ORM\OneToMany(targetEntity=Asset::class, mappedBy="artefact", orphanRemoval=true)
     */
    private $assets;

    public function __construct()
    {
        $this->assets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
