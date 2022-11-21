<?php

declare(strict_types=1);

namespace Cbase\ArtefactGuide\Domain;

use Cbase\ArtefactGuide\Infrastructure\Persistence\Doctrine\ImageIdType;
use Cbase\Shared\Domain\Aggregate\AggregateRoot;
use Cbase\Shared\Domain\Utils\CollectionUtils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Cbase\Shared\Domain\ImageId;

#[ORM\Entity]
#[ORM\Table(name: 'image')]
class Image extends AggregateRoot implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\Column(type: ImageIdType::TYPE, name: 'id')]
    private ImageId $imageId;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true, nullable: false)]
    private string $path;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private string $description;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private string $author;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: false)]
    private \DateTimeInterface $createdAt;

    #[ORM\Embedded(class: Licence::class, columnPrefix: false)]
    private Licence $licence;

    #[ORM\ManyToMany(targetEntity: Artefact::class, mappedBy: 'images')]
    private Collection $artefacts;

    public function __construct()
    {
        $this->artefacts = new ArrayCollection();
    }

    public static function create(
        ImageId $imageId,
        string $path,
        string $description,
        string $author,
        \DateTimeInterface $createdAt,
        Licence $licence,
    ): self {
        $image = new self();
        $image->imageId = $imageId;
        $image->path = $path;
        $image->description = $description;
        $image->author = $author;
        $image->createdAt = $createdAt;
        $image->licence = $licence;

        return $image;
    }

    public function getImageId(): ImageId
    {
        return $this->imageId;
    }

    public function addArtefact(Artefact $artefact): void
    {
        if (!$this->artefacts->contains($artefact)) {
            $this->artefacts->add($artefact);
        }
    }

    /**
     * @return array<string, string|array<string>>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->imageId->value(),
            'path' => $this->path,
            'description' => $this->description,
            'author' => $this->author,
            'createdAt' => $this->createdAt->format('Y-m-d'),
            'licence' => $this->licence->value(),
            'artefacts' => CollectionUtils::map($this->artefacts, fn(Artefact $artefact) => $artefact->getSlug()->value()),
        ];
    }

    public function equals(ImageId $imageId): bool
    {
        return $this->imageId->equals($imageId);
    }
}
