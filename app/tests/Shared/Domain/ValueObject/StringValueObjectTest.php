<?php

declare(strict_types=1);

namespace Tests\Shared\Domain\ValueObject;

use Cbase\ArtefactGuide\Domain\Slug;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class StringValueObjectTest extends UnitTestCase
{
    public function test_value_object_can_be_treated_as_string(): void
    {
        $string = Slug::create('slug');

        self::assertEquals('slug', $string);
    }
}
