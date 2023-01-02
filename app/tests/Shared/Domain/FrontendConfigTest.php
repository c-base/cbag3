<?php

declare(strict_types=1);

namespace Tests\Shared\Domain;

use Cbase\Shared\Domain\FrontendConfig;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class FrontendConfigTest extends UnitTestCase
{
    public function test_values_can_be_added(): void
    {
        $config = new FrontendConfig();
        $config['answer-to-everything'] = ['guess' => 42];

        self::assertArrayHasKey('answer-to-everything', $config);
        self::assertEquals(['guess' => 42], $config['answer-to-everything']);
    }

    public function test_is_config_serializable(): void
    {
        $config = new FrontendConfig();
        $config['answer-to-everything'] = ['guess' => 42];

        self::assertEquals('{"answer-to-everything":{"guess":42}}', json_encode($config));
    }

    public function test_is_config_resettable(): void
    {
        $config = new FrontendConfig();
        $config['answer-to-everything'] = ['guess' => 42];

        $config->reset();

        self::assertEmpty($config->jsonSerialize());
    }

    public function test_is_config_can_be_unset(): void
    {
        $config = new FrontendConfig();
        $config['answer-to-everything'] = ['guess' => 42];

        unset($config['answer-to-everything']);

        self::assertEmpty($config->jsonSerialize());
    }
}
