<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Shared\Domain;

use Shared\Domain\Contract\UuidCreatable;
use Shared\Domain\ValueObject\Uuid;

final class ArtefactId extends Uuid
{
    use UuidCreatable;
}
