<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 */
class Artefact
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
     * @ORM\Column
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column
     * @Assert\NotBlank
     */
    private $slug;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\NotBlank
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
     * Many artefacts have Many assets.
     * @ORM\ManyToMany(targetEntity="Asset", inversedBy="artefacts")
     * @ORM\JoinTable(name="artefact_asset")
     *
     *
     * @var \Doctrine\Common\Collections\Collection|Asset[]
     *
     * @ORM\ManyToMany(targetEntity="Asset", inversedBy="artefacts")
     * @ORM\JoinTable(
     *  name="artefact_asset",
     *  joinColumns={
     *      @ORM\JoinColumn(name="artefact_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="asset_id", referencedColumnName="id")
     *  }
     * )
     */
    private $assets;

    public function __construct($name, $slug, $description, \DateTime $createdAt, $createdBy) {
        $this->name = $name;
        $this->slug = $slug;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->createdBy = $createdBy;
        $this->assets = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    /**
     * @return Asset[]|\Doctrine\Common\Collections\Collection
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * @param Asset $asset
     */
    public function addAsset(Asset $asset)
    {
        if ($this->assets->contains($asset)) {
            return;
        }
        $this->assets->add($asset);
        $asset->addArtefact($this);
    }
    /**
     * @param Asset $asset
     */
    public function removeAsset(Asset $asset)
    {
        if (!$this->assets->contains($asset)) {
            return;
        }
        $this->assets->removeElement($asset);
        $asset->removeArtefact($this);
    }
}
