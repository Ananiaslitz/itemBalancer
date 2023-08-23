<?php

namespace Ananiaslitz\ItemBalancer\Cache;

class RedisCache implements CacheInterface {
    private $client;

    public function __construct() {
        $this->client = new Predis\Client();
    }

    public function get(string $key): int {
        return (int) $this->client->get($key);
    }

    public function increment(string $key): void {
        $this->client->incr($key);
    }
}
