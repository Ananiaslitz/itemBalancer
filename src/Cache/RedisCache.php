<?php

namespace Ananiaslitz\ItemBalancer\Cache;

use Ananiaslitz\ItemBalancer\Contracts\CacheInterface;
use Predis\Client;

class RedisCache implements CacheInterface {
    private Client $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function get(string $key): int {
        return (int) $this->client->get($key);
    }

    public function increment(string $key): void {
        $this->client->incr($key);
    }
}
