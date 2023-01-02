<?php

declare(strict_types=1);

namespace Cbase\Shared\Domain;

use Cbase\Shared\Domain\Contract\UuidCreatable;
use Cbase\Shared\Domain\ValueObject\Uuid;

final class ArtefactId extends Uuid
{
    use UuidCreatable;
}
