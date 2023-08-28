<?php

namespace Ananiaslitz\ItemBalancer\Cache;

use Ananiaslitz\ItemBalancer\Contracts\CacheInterface;
use Predis\Client;

class RedisCache implements CacheInterface {
    private Client $client;

    public function __construct() {
        $host = getenv('REDIS_HOST') ?: '127.0.0.1';
        $port = getenv('REDIS_PORT') ?: 6379;

        $this->client = new Client([
            'scheme' => 'tcp',
            'host'   => $host,
            'port'   => $port,
        ]);
    }

    public function get(string $key): int {
        return (int) $this->client->get($key);
    }

    public function increment(string $key): void {
        $this->client->incr($key);
    }
}
