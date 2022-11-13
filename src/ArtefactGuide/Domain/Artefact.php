<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Domain;

use Cbase\ArtefactGuide\Infrastructure\Persistence\Doctrine\ArtefactIdType;
use Cbase\Shared\Domain\Aggregate\AggregateRoot;
use Cbase\Shared\Domain\ArtefactId;
use Cbase\Shared\Domain\ImageId;
use Cbase\Shared\Domain\MemberName;
use Cbase\Shared\Domain\Utils\CollectionUtils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity]
class Artefact extends AggregateRoot implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\Column(type: ArtefactIdType::TYPE, name: 'id')]
    private ArtefactId $artefactId;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, nullable: false)]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, nullable: false)]
    private string $cName;

    #[MaxDepth(3)]
    #[ORM\Embedded(class: Slug::class, columnPrefix: false)]
    private Slug $slug;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private string $description;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: false)]
    private \DateTimeInterface $createdAt;

//    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: false)]
//    private \DateTimeInterface $updatedAt;

    #[ORM\Embedded(class: MemberName::class, columnPrefix: false)]
    private MemberName $createdBy;

    #[ORM\OneToOne(targetEntity: Image::class)]
    #[ORM\JoinColumn(name: 'primary_image_id', referencedColumnName: 'id', unique: false, nullable: true)]
    private ?Image $primaryImage;

    /**
     * @var Collection<Image>
     */
    #[ORM\ManyToMany(targetEntity: Image::class, inversedBy: 'artefacts')]
    #[ORM\JoinTable(name: 'artefact_image')]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public static function create(
        ArtefactId $artefactId,
        string $name,
        string $cName,
        Slug $slug,
        string $description,
        \DateTimeInterface $createdAt,
        MemberName $createdBy,
        ?Image $primaryImage = null
    ): self {
        $artefact = new self();
        $artefact->artefactId = $artefactId;
        $artefact->name = $name;
        $artefact->cName = $cName;
        $artefact->slug = $slug;
        $artefact->description = $description;
        $artefact->createdAt = $createdAt;
        $artefact->createdBy = $createdBy;
        $artefact->primaryImage = $primaryImage;

        return $artefact;
    }

    public function addImage(Image $image): void
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->addArtefact($this);
        }
    }

    public function removeImage(Image $image): void
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            $image->removeArtefact($this);
        }
    }

    /**
     * @return array<string, array|\Cbase\ArtefactGuide\Domain\Image|string|null>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'cName' => $this->cName,
            'slug' => $this->slug->value(),
            'description' => $this->description,
            'createdAt' => $this->createdAt->format('Y-m-d'),
            'createdBy' => $this->createdBy->value(),
            'primaryImage' => $this->primaryImage?->jsonSerialize(),
            'images' => CollectionUtils::map((fn (Image $image) => $image->jsonSerialize()), $this->images)
        ];
    }

    public function getImage(ImageId $imageId): ?Image
    {
        /** @var Image $image */
        foreach ($this->images as $image) {
            if ($image->equals($imageId)) {
                return $image;
            }
        }
        return null;
    }

    public function setPrimaryImage(?Image $image): void
    {
        $this->primaryImage = $image;
    }

    public function setImages(Collection $images): void
    {
        $this->images = $images;
    }
}
