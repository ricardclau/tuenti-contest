#!/usr/bin/php
<?php

$lines = file('php://stdin');
$lines = array_map('trim', $lines);

$numcombis = $lines[0];
for($i = 0; $i < $numcombis; $i++) {
    $comb = explode(' ', $lines[2*$i + 1]);
    sort($comb);
    $combis[$lines[2*$i+2]] = implode(' ', $comb);
}

$numtests = $lines[2*$numcombis + 1];

for($i = 2*$numcombis + 2; $i < count($lines); $i++) {
    $tests[] = $lines[$i];
}

foreach($tests as $test) {
    $seq = explode(' ', $test);
    sort($seq);
    echo array_search(implode(' ', $seq), $combis) . PHP_EOL;
}