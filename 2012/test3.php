#!/usr/bin/php
<?php

$lines = array_map('trim', file('php://stdin'));

$iters = count($lines) - 1;
$benefit = 0;
for ($i = 0; $i < $iters; $i++) {
    $buyAt = $i * 100;
    $buyValue = $lines[$i];
    $possibleSelling = array_slice($lines, ($i + 1));
    $sellValue = max($possibleSelling);
    $sellAt = (array_search($sellValue, $lines)) * 100;

    if ($sellValue - $buyValue > $benefit) {
        $finalBuy = $buyAt;
        $finalSell = $sellAt;
        $benefit = ($sellValue - $buyValue);
    }
}

echo $finalBuy . ' ' . $finalSell . ' ' . $benefit . PHP_EOL;