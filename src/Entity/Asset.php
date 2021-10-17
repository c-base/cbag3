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
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(type="string", length=25)
     */
    private $license;

    /**
     * @ORM\ManyToOne(targetEntity=Artefact::class, inversedBy="assets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $artefact;

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
}
