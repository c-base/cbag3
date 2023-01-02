<?php

declare(strict_types=1);

namespace Tests\Shared\Domain\Utils;

use Cbase\Shared\Domain\Utils\CollectionUtils;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class CollectionUtilsTest extends UnitTestCase
{
    public function test_map_array(): void
    {
        $array = [1, 2, 3];
        $result = CollectionUtils::map($array, fn ($item) => $item + 1);

        self::assertEquals([2, 3, 4], $result);
    }

    public function test_key_array(): void
    {
        $array = [1, 2, 3];
        $result = CollectionUtils::keyBy($array, fn ($item) => $item + 1);

        self::assertEquals([2 => 1, 3 => 2, 4 => 3], $result);
    }
}
