#!/usr/bin/php
<?php

$lines = file('php://stdin');
$lines = array_map('trim', $lines);

foreach($lines as $line) {
    $data = explode(' ', $line);
    $colors = array(1);

    $cwidth = array_shift($data);
    $cheight = array_shift($data);
    $squares = array_shift($data);

    for($i=0; $i < $cwidth; $i++) {
        for($j=0; $j < $cheight; $j++) {
            $canvas[$i][$j] = 1;
        }    
    }

    for($sq = 0; $sq < $squares; $sq++) {
        $tx = array_shift($data);
        $ty = array_shift($data);
        $bx = array_shift($data);
        $by = array_shift($data);
        $color = array_shift($data);
        $colors[] = $color;

        for($i=$tx; $i<$bx;$i++) {
            for($j=$ty; $j<$by;$j++) {
                $canvas[$i][$j] = $color;
            }
        }
    }

    $out = '';
    foreach($colors as $color) {
        $maybe = countcolor($canvas, $color, $cwidth, $cheight);
        if($maybe > 0) $out .= $color . ' ' . $maybe . ' ';
    }
    echo trim($out) . PHP_EOL;
}

function countcolor($canvas, $color, $cwidth, $cheight) {
    $count = 0;
    for($i=0; $i < $cwidth; $i++) {
        for($j=0; $j < $cheight; $j++) {
            if($canvas[$i][$j] == $color) $count++;
        }
    }
    return $count;
}