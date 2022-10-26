<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace ArtefactGuide\Domain;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Shared\Domain\ValueObject\StringValueObject;

#[ORM\Embeddable]
final class MemberName extends StringValueObject
{
    #[ORM\Column(name: 'created_by', type: Types::STRING, length: 32, nullable: false)]
    protected string $value;

    public static function create(string $value): self
    {
        return new self($value);
    }
}
