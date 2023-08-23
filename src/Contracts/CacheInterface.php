<?php 

namespace Ananiaslitz\ItemBalancer\Contracts;

interface CacheInterface
{
    public function get(string $key): int;
    public function increment(string $key): void;
}