<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\ArtefactGuide\Domain;

use Cbase\ArtefactGuide\Domain\Licence;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class LicenceTest extends UnitTestCase
{
    public function test_licence_can_be_created_with_valid_values()
    {
        self::assertInstanceOf(Licence::class, Licence::create(Licence::CC_BY));
        self::assertInstanceOf(Licence::class, Licence::create(Licence::CC_BY_SA));
    }

    public function test_licence_creation_fails_with_invalid_value()
    {
        $this->expectException(\InvalidArgumentException::class);
        Licence::create('NO_LICENCE');
    }
}
