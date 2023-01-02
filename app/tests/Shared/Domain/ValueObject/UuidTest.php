<?php

declare(strict_types=1);

namespace Tests\Shared\Domain\ValueObject;

use Cbase\Shared\Domain\ValueObject\Uuid;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class UuidTest extends UnitTestCase
{
    public function test_uuid_can_instantiated_with_factory(): void
    {
        $uuid = Uuid::random();

        self::assertInstanceOf(Uuid::class, $uuid);
    }

    public function test_uuid_can_instantiated_with_constructor(): void
    {
        $uuid = new Uuid(Uuid::random()->value());

        self::assertInstanceOf(Uuid::class, $uuid);
    }

    public function test_uuid_can_instantiated_with_valid_uuid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $uuid = new Uuid('abc-123');
    }
}
