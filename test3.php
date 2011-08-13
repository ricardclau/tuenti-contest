#!/usr/bin/php
<?php

function checkifprime($prime){
    if($prime % 2 == 0) return false;
    $max = sqrt($prime);
    for($i = 3; $i <= $max; $i = $i+2){
        if ($prime % $i == 0) {
            return false;
        }
    }
    return true;
}


function generaEmirps($max) {
    $primos = array();
    for($i = 11; $i <= $max; $i = $i+2){
        if(checkifprime($i)){
            $primos[] = $i;
        }
    }
    
    $emirps = array();
    $total = count($primos);
    for($i = 0; $i < $total; $i++) {
        $reverse = strrev($primos[$i]);
        if($reverse == $primos[$i]) continue;
        if(checkifprime($reverse)) {
            $emirps[] = $primos[$i];    
        }
    }
    return $emirps;

}

$lines = file('php://stdin');
// $lines = array(100, 200);


$max = 0;
foreach($lines as $line) {
    $line = trim($line);
    if($line > $max) $max = $line;
}

$emirps = generaEmirps($max);

foreach($lines as $line) {
    $line = trim($line);
    $sum = 0;
    foreach($emirps as $emirp) {
        if($emirp > $line) break;
        $sum += $emirp;
    }
    echo $sum . PHP_EOL;
}