<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace ArtefactGuide\Domain;

use ArtefactGuide\Infrastructure\Persistence\Doctrine\ArtefactIdType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\ArtefactId;
use Shared\Domain\Contract\Normalizable;
use Shared\Domain\Utils\CollectionUtils;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity]
class Artefact extends AggregateRoot implements Normalizable
{
    #[ORM\Id]
    #[ORM\Column(type: ArtefactIdType::TYPE, name: 'id')]
    private readonly ArtefactId $artefactId;

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

    #[ORM\Embedded(class: MemberName::class, columnPrefix: false)]
    private MemberName $createdBy;

    #[ORM\OneToOne(targetEntity: Image::class)]
    #[ORM\JoinColumn(name: 'primary_image_id', referencedColumnName: 'id', unique: false, nullable: true)]
    private ?Image $primaryImage;

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
    ): self
    {
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

    public function normalize(): array
    {
        return [
            'name' => $this->name,
            'cName' => $this->cName,
            'slug' => $this->slug->value(),
            'description' => $this->description,
            'createdAt' => $this->createdAt->format('Y-m-d'),
            'createdBy' => $this->createdBy->value(),
            'primaryImage' => $this->primaryImage?->normalize(),
            'images' => CollectionUtils::map((fn($image) => $image->normalize()) , $this->images)
        ];
    }
}
