<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Cbase\Shared\Domain;

use Cbase\Shared\Domain\Contract\UuidCreatable;
use Cbase\Shared\Domain\ValueObject\Uuid;

final class ImageId extends Uuid
{
    use UuidCreatable;
}