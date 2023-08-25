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
        $category = $this->getRandomCategoryBasedOnProportions();
        $this->cache->increment($category);

        return ['item' => $item, 'category' => $category];
    }

    private function getRandomCategoryBasedOnProportions(): string
    {
        $weights = [];

        $totalItems = array_sum(array_map(fn($cat) => $this->cache->get($cat), $this->categories));

        foreach ($this->categories as $index => $category) {
            $desiredCount = $totalItems * ($this->percentages[$index] / 100);
            $weights[$category] = $desiredCount - $this->cache->get($category);
        }

        return $this->getRandomCategoryWithWeights($weights);
    }

    private function getRandomCategoryWithWeights(array $weights): string
    {
        $totalWeight = array_sum($weights);
        $randomWeight = mt_rand(1, $totalWeight);

        foreach ($weights as $category => $weight) {
            if ($randomWeight <= $weight) {
                return $category;
            }
            $randomWeight -= $weight;
        }

        return $this->categories[0]; // fallback
    }
}
