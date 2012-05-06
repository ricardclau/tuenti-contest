#!/usr/bin/php
<?php

$lines = array_map('trim', file('php://stdin'));
//$lines = array(
//'3',
//'1',
//'6',
//'2135',
//);

$cases = array_shift($lines);

function allAreOnes($strBase2)
{
    $iter = strlen($strBase2);
    for ($j = 0; $j < $iter; $j++) {
        if ($strBase2[$j] === '0') return false;
    }
    return true;
}

for ($i = 0; $i < $cases; $i++) {
    $hazelnuts = 0;
    $number = $lines[$i];
    $numberBase2 = base_convert($number, 10, 2);
    // 1. Check if already all 1
    if (allAreOnes($numberBase2)) {
        $hazelnuts = strlen($numberBase2);
    } else {
        // 2. Create a number of all 1s with strlen - 1 and get the other number
        $maxAllOnes = implode('', array_fill(0, strlen($numberBase2) - 1, '1'));
        $otherNum = bcsub($number, base_convert($maxAllOnes, 2, 10));
        $otherNumBase2 = base_convert($otherNum, 10, 2);
        $hazelnuts = strlen($maxAllOnes);
        $oIters = strlen($otherNumBase2);
        for ($otherNumDigits = 0; $otherNumDigits < $oIters; $otherNumDigits++) {
            if ($otherNumBase2[$otherNumDigits] === '1') {
                $hazelnuts++;
            }
        }
    }

    echo 'Case #' . ($i + 1) . ': ' . $hazelnuts .  PHP_EOL;
}