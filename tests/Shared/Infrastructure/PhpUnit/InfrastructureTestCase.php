<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\PhpUnit;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\SerializerInterface;

abstract class InfrastructureTestCase extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel(['environment' => 'test']);

        parent::setUp();
    }

    protected function service(string $id): mixed
    {
        return $this->getContainer()->get($id);
    }
}
