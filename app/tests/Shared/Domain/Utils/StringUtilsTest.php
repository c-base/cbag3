<?php

declare(strict_types=1);

namespace Tests\Shared\Domain\Utils;

use Cbase\Shared\Domain\Utils\StringUtils;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class StringUtilsTest extends UnitTestCase
{
    public function test_sluggify_with_empty(): void
    {
        self::assertSluggify('', '');
    }

    public function test_sluggify_works(): void
    {
        self::assertSluggify('123', '123');
        self::assertSluggify('abc', 'abc');
    }

    public function test_sluggify_lowers_all_charcters(): void
    {
        self::assertSluggify('AundB', 'aundb');
        self::assertSluggify('aUndB', 'aundb');
    }

    public function test_sluggify_replaces_umlaute(): void
    {
        self::assertSluggify('cultorgabrücce', 'cultorgabruecce');
        self::assertSluggify('lötstelle', 'loetstelle');
        self::assertSluggify('ctänder', 'ctaender');
        self::assertSluggify('ß-zett', 'ss-zett');
    }

    public function test_sluggify_replaces_all_other_special_characters_and_spaces(): void
    {
        self::assertSluggify('bru:cce', 'bru-cce');
        self::assertSluggify('DuC_e', 'duc-e');
        self::assertSluggify('millenium falcon', 'millenium-falcon');
        self::assertSluggify('c-info', 'c-info');
        self::assertSluggify(' doppel  space ', 'doppel-space');
    }

    private static function assertSluggify(string $text, string $expected): void
    {
        $actual = StringUtils::sluggify($text);
        self::assertEquals($expected, $actual, sprintf('"%s" was sluggified to "%s", but expected "%s"', $text, $actual, $expected));
    }

    public function test_snake_case_with_empty(): void
    {
        self::assertSnakeCase('', '');
    }

    public function test_snake_case_with_camelcase_string(): void
    {
        self::assertSnakeCase('halloWelt', 'hallo_welt');
    }

    private static function assertSnakeCase(string $text, string $expected): void
    {
        $actual = StringUtils::toSnakeCase($text);
        self::assertEquals($expected, $actual, sprintf('"%s" was snake_cased to "%s", but expected "%s"', $text, $actual, $expected));
    }

    public function test_camel_case_with_empty(): void
    {
        self::assertCamelCase('', '');
    }

    public function test_camel_case_with_snake_case_string(): void
    {
        self::assertCamelCase('hallo_welt', 'halloWelt');
    }

    private static function assertCamelCase(string $text, string $expected): void
    {
        $actual = StringUtils::toCamelCase($text);
        self::assertEquals($expected, $actual, sprintf('"%s" was camelCased to "%s", but expected "%s"', $text, $actual, $expected));
    }
}
