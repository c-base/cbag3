<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\Factory;

use Shared\Domain\ArtefactId;

final class ArtefactIdFactory
{
    public static function create(string $value): ArtefactId
    {
        return new ArtefactId($value);
    }
}
