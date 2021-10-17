<?php

namespace App\Entity;

use App\Repository\AssetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssetRepository::class)
 */
class Asset
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private string $path;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private string $author;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private \DateTime $createdAt;

    /**
     * @var string
     * @ORM\Column(type="string", length=25)
     */
    private string $license;

    /**
     * @ORM\ManyToOne(targetEntity=Artefact::class, inversedBy="assets")
     * @ORM\JoinColumn(nullable=false)
     */
    private Artefact $artefact;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtefact(): ?Artefact
    {
        return $this->artefact;
    }

    public function setArtefact(?Artefact $artefact): self
    {
        $this->artefact = $artefact;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
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

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getLicense(): string
    {
        return $this->license;
    }

    public function setLicense(string $license): Asset
    {
        $this->license = $license;
        return $this;
    }
}
