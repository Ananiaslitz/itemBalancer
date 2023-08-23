<?php

namespace Ananiaslitz\ItemBalancer\Distributor;

use Ananiaslitz\ItemBalancer\Contracts\CacheInterface;

class Distributor
{
    private $cache;
    private $categories;
    private $percentages;

    public function __construct(CacheInterface $cache, array $categories, array $percentages)
    {
        $this->cache = $cache;
        $this->categories = $categories;
        $this->percentages = $percentages;
    }

    public function distribute(string $item): array
    {
        $category = $this->getCategoryForDistribution();
        $this->cache->increment($category);

        return ['item' => $item, 'category' => $category];
    }

    private function getCategoryForDistribution(): string
    {
        $totalItems = array_sum(array_map(fn($cat) => $this->cache->get($cat), $this->categories));

        foreach ($this->categories as $index => $category) {
            $desiredCount = $totalItems * ($this->percentages[$index] / 100);
            if ($this->cache->get($category) < $desiredCount) {
                return $category;
            }
        }

        return $this->categories[0];
    }
}
