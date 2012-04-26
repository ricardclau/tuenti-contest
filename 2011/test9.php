#!/usr/bin/php
<?php

$lines = file('php://stdin');

$numcases = $lines[0];
for($i = 0; $i < $numcases; $i++) {
    $cases[] = array($lines[2*$i + 1],$lines[2*$i+2]);
}

foreach($cases as $case) {
    $lights = $case[0];
    $time = $case[1];
    $time = $time % $lights;
    
    if($time == 0) {
        echo 'All lights are off :('. PHP_EOL;
        continue;
    }    
    $out = '';
    for($i = (int)($time % 2 == 0); $i < $time; $i= $i+2) {
       $out .= $i .' ';
    }
    echo trim($out) . PHP_EOL;    
}