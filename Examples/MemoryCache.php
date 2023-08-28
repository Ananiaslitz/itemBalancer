<?php

namespace Examples;

use Ananiaslitz\ItemBalancer\Contracts\CacheInterface;

class MemoryCache implements CacheInterface
{
    private $data = [];

    public function get(string $key): int
    {
        return $this->data[$key] ?? 0;
    }

    public function increment(string $key): void
    {
        if (!isset($this->data[$key])) {
            $this->data[$key] = 0;
        }
        $this->data[$key]++;
    }
}
