<?php

declare(strict_types=1);

namespace Cbase\App\Domain;

use Symfony\Contracts\Service\ResetInterface;

final class FrontendConfig implements ResetInterface
{
    public function __construct(private array $config = [])
    {
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function addConfig(string $key, array $values)
    {
        $this->config[$key] = $values;
    }

    public function reset()
    {
        $this->config = [];
    }
}
