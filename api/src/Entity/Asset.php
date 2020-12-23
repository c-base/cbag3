<?php
/*
 * (c) 2018 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Asset
{
    /**
     * @var int
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
     * @var Collection|Artefact[]
     *
     * Many artefacts have Many assets.
     * @ORM\ManyToMany(targetEntity="Artefact", mappedBy="assets")
     */
    private $artefacts;

    public function __construct($path, $description, $author, $license)
    {
        $this->path = $path;
        $this->description = $description;
        $this->author = $author;
        $this->license = $license;
        $this->artefacts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getLicense(): string
    {
        return $this->license;
    }

    public function getArtefacts(): Collection
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
