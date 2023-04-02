<?php

declare(strict_types=1);

namespace Cbase\Shared\Domain;

use Symfony\Contracts\Service\ResetInterface;

/**
 * @implements \ArrayAccess<string, array<string, mixed>>
 */
final class FrontendConfig implements \ArrayAccess, ResetInterface, \JsonSerializable
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $config = [];

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->config[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->config[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->config[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->config[$offset]);
    }


    public function reset(): void
    {
        $this->config = [];
    }

    public function jsonSerialize(): mixed
    {
        return $this->config;
    }
}
