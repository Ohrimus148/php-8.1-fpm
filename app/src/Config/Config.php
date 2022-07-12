<?php

declare(strict_types = 1);

namespace Socket\Chat\Config;

/**
 * @property-read ?array $db
 */
class Config
{
    protected array $config = [];

    public function __construct()
    {
        $this->config = [
            'db' => [
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}