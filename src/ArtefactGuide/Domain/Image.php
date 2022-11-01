<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\ArtefactGuide\Domain;

use Cbase\ArtefactGuide\Infrastructure\Persistence\Doctrine\ImageIdType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Cbase\Shared\Domain\Contract\Normalizable;
use Cbase\Shared\Domain\ImageId;

#[ORM\Entity]
#[ORM\Table(name: 'image')]
class Image implements Normalizable
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
    public readonly Licence $licence;

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

    public function addArtefact(Artefact $artefact): void
    {
        if (!$this->artefacts->contains($artefact)) {
            $this->artefacts->add($artefact);
        }
    }

    public function normalize(): array
    {
        return [
            'path' => $this->path,
            'description' => $this->description,
            'author' => $this->author,
            'createdAt' => $this->createdAt->format('Y-m-d'),
            'licence' => $this->licence->value(),
        ];
    }
}
