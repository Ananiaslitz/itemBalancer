<?php

require_once 'vendor/autoload.php';

use Ananiaslitz\ItemBalancer\Distributor\Distributor;
use Examples\MemoryCache;

$cache = new MemoryCache();

$categories = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
$percentages = [10, 15, 12, 8, 5, 20, 10, 7, 8, 5];

$distributor = new Distributor($cache, $categories, $percentages);

$start = microtime(true);

$iterations = 1053;
$results = array_fill_keys($categories, 0);

for ($i = 0; $i < $iterations; $i++) {
    $item = "Item_$i";
    $result = $distributor->distribute($item);
    $results[$result['category']]++;
    echo "{$result['item']} foi distribuído para a categoria {$result['category']}\n";
}

$end = microtime(true);

echo "\nResumo:\n";
foreach ($categories as $index => $category) {
    $expected = $percentages[$index] * 0.01 * $iterations;
    $marginOfError = abs($results[$category] - $expected);
    echo "{$category}: {$results[$category]} (esperado: {$expected}, margem de erro: ±{$marginOfError})\n";
}
printf("A distribuição levou %.4f segundos.", ($end - $start));
echo PHP_EOL;
