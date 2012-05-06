#!/usr/bin/php
<?php

$lines = array_map('trim', file('php://stdin'));

//$lines = array(
//'2',
//'HI 20',
//'tu',
//);
/**
 * Keypad map
 */
$chars = array(
   '0' => array('0'),
   '1' => array(' ', '1'),
   '2' => array('a', 'b', 'c', '2'),
   '3' => array('d', 'e', 'f', '3'),
   '4' => array('g', 'h', 'i', '4'),
   '5' => array('j', 'k', 'l', '5'),
   '6' => array('m', 'n', 'o', '6'),
   '7' => array('p', 'q', 'r', 's', '7'),
   '8' => array('t', 'u', 'v', '8'),
   '9' => array('w', 'x', 'y', 'z', '9'),
   'caps' => array('caps')
);

/**
 * Distance matrix costs
 */
$distances = array(
    '0' => array(
        '1' => 950,
        '2' => 900,
        '3' => 950,
        '4' => 650,
        '5' => 600,
        '6' => 650,
        '7' => 350,
        '8' => 300,
        '9' => 350,
        'caps' => 200,
    ),
    '1' => array(
        '0' => 950,
        '2' => 200,
        '3' => 400,
        '4' => 300,
        '5' => 350,
        '6' => 550,
        '7' => 600,
        '8' => 650,
        '9' => 700,
        'caps' => 1000,
    ),
    '2' => array(
        '0' => 900,
        '1' => 200,
        '3' => 200,
        '4' => 350,
        '5' => 300,
        '6' => 350,
        '7' => 650,
        '8' => 600,
        '9' => 650,
        'caps' => 950,
    ),
    '3' => array(
        '0' => 950,
        '1' => 400,
        '2' => 200,
        '4' => 550,
        '5' => 350,
        '6' => 300,
        '7' => 700,
        '8' => 650,
        '9' => 600,
        'caps' => 900,
    ),
    '4' => array(
        '0' => 650,
        '1' => 300,
        '2' => 350,
        '3' => 550,
        '5' => 200,
        '6' => 400,
        '7' => 300,
        '8' => 350,
        '9' => 550,
        'caps' => 700,
    ),
    '5' => array(
        '0' => 600,
        '1' => 350,
        '2' => 300,
        '3' => 350,
        '4' => 200,
        '6' => 200,
        '7' => 350,
        '8' => 300,
        '9' => 350,
        'caps' => 650,
    ),
    '6' => array(
        '0' => 650,
        '1' => 550,
        '2' => 350,
        '3' => 300,
        '4' => 400,
        '5' => 200,
        '7' => 550,
        '8' => 350,
        '9' => 300,
        'caps' => 600,
    ),
    '7' => array(
        '0' => 350,
        '1' => 600,
        '2' => 650,
        '3' => 700,
        '4' => 300,
        '5' => 350,
        '6' => 550,
        '8' => 200,
        '9' => 400,
        'caps' => 550,
    ),
    '8' => array(
        '0' => 300,
        '1' => 650,
        '2' => 600,
        '3' => 650,
        '4' => 350,
        '5' => 300,
        '6' => 350,
        '7' => 200,
        '9' => 200,
        'caps' => 350,
    ),
    '9' => array(
        '0' => 350,
        '1' => 700,
        '2' => 650,
        '3' => 600,
        '4' => 550,
        '5' => 350,
        '6' => 300,
        '7' => 400,
        '8' => 200,
        'caps' => 300,
    ),
    'caps' => array(
        '0' => 200,
        '1' => 1000,
        '2' => 950,
        '3' => 900,
        '4' => 700,
        '5' => 650,
        '6' => 600,
        '7' => 550,
        '8' => 350,
        '9' => 300,
    ),
);

function locateChar($char, array $chars) {
    foreach ($chars as $location => $charset) {
        if (false !== array_search(strtolower($char), $charset)) {
            return $location;
        }
    }
}

/**
 * Obtain test cases
 */
$cases = array_shift($lines);
foreach($lines as $line) {
    /**
     * Initial conditions
     */
    $time = 0;
    $caps = 'low';
    $pos = '0';

    $msgLength = strlen($line);
    for ($c = 0; $c < $msgLength; $c++) {
        $newChar = $line[$c];
        $newPos = locateChar($newChar, $chars);

        // 1 - Check if need to change caps
        if (!is_numeric($newChar) &&
            (
                ($caps == 'low' && strtolower($newChar) !== $newChar) ||
                ($caps == 'upp' && strtoupper($newChar) !== $newChar)
            )) {
            $time += $distances[$pos]['caps'];
            $time += 100;
            $pos = 'caps';
            if ($caps == 'low') $caps = 'upp'; else $caps = 'low';
        }

        // 2 - Move to new pos
        if ($newPos != $pos) {
            $time += $distances[$pos][$newPos];
            $pos = $newPos;
        } else {
            $time += 500;
        }

        // 3 - Compute typing
        $time += (1 + array_search(strtolower($newChar), $chars[$pos])) * 100;
    }


    echo $time . PHP_EOL;
}
