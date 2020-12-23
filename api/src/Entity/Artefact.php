<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 *
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
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=32, unique=true, nullable=false)
     * @Assert\NotBlank
     */
    private $slug;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    private $createdAt;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank
     */
    private $createdBy;

    /**
     * Many artefacts have Many assets.
     * @ORM\ManyToMany(targetEntity="Asset", inversedBy="artefacts")
     * @ORM\JoinTable(name="artefact_asset")
     *
     *
     * @var Collection|Asset[]
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

    public function __construct($name, $slug = null, $description = '', \DateTime $createdAt = null, $createdBy = '')
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->description = $description;
        $this->createdAt = $createdAt === null ? new \DateTime('now') : $createdAt;
        $this->createdBy = $createdBy;
        $this->assets = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function setSlug(string $slug)
    {
        $this->slug = $slug;
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

    public function setCreatedBy(string $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    /**
     * @return Asset[]|Collection
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
