<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
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

    protected function getSerializer(): \Symfony\Component\Serializer\Serializer
    {
        return $this->service('serializer');
    }
}
