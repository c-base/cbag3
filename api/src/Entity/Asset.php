<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Asset
{
    /**
     * @var int The entity Id
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column()
     */
    private $path;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string
     * @ORM\Column()
     */
    private $author;

    /**
     * @var string
     * @ORM\Column()
     */
    private $license;

    /**
     * @var \Doctrine\Common\Collections\Collection|Artefact[]
     *
     * Many artefacts have Many assets.
     * @ORM\ManyToMany(targetEntity="Artefact", mappedBy="assets")
     */
    private $artefacts;

    public function __construct($path, $description, $author, $license) {
        $this->path = $path;
        $this->description = $description;
        $this->author = $author;
        $this->license = $license;
        $this->artefacts = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getLicense(): string
    {
        return $this->license;
    }

    /**
     * @return Artefact[]|\Doctrine\Common\Collections\Collection
     */
    public function getArtefacts()
    {
        return $this->artefacts;
    }

    /**
     * @param Artefact $artefact
     */
    public function addArtefact(Artefact $artefact)
    {
        if ($this->artefacts->contains($artefact)) {
            return;
        }
        $this->artefacts->add($artefact);
        $artefact->addAsset($this);
    }

    /**
     * @param Artefact $artefact
     */
    public function removeArtefact(Artefact $artefact)
    {
        if (!$this->artefacts->contains($artefact)) {
            return;
        }
        $this->artefacts->removeElement($artefact);
        $artefact->removeAsset($this);
    }
}
