#!/opt/local/bin/php
<?php

$letterValues = array(
    'A' => 1,
    'E' => 1,
    'I' => 1,
    'L' => 1,
    'N' => 1,
    'O' => 1,
    'R' => 1,
    'S' => 1,
    'T' => 1,
    'U' => 1,
    'D' => 2,
    'G' => 2,
    'B' => 3,
    'C' => 3,
    'M' => 3,
    'P' => 3,
    'F' => 4,
    'H' => 4,
    'V' => 4,
    'W' => 4,
    'Y' => 4,
    'K' => 5,
    'J' => 8,
    'X' => 8,
    'Q' => 10,
    'Z' => 10,
);

function getPoints($word, $letterValues)
{
    return array_reduce(str_split($word), function($res, $val) use ($letterValues) {
        return $res + $letterValues[$val];
    });
}


function arrayLetraCount($str)
{
    $tengo = array();
    foreach (count_chars($str, 1) as $i => $val) {
        $tengo[chr($i)] = $val;
    }

    return $tengo;
}


$fd = fopen('descrambler_wordlist.txt', 'r');
$words = array();
while (!feof($fd)) {
    $word = trim(fgets($fd));
    if (!empty($word)) {
        $words[] = array(
            'w' => $word,
            'p' => getPoints($word, $letterValues),
            'c' => arrayLetraCount($word),
        );
    }
}

fclose($fd);

usort($words, function($a, $b) {
   return (($a['p'] > $b['p']) || ($a['p'] == $b['p'] && $a['w'] < $b['w'])) ? -1 : 1;
});


function mejorPalabra($fichas, $puntos = 0)
{
    global $words;
    $tengo = arrayLetraCount(implode('', $fichas));
    $tengoC = array_sum($tengo) + 1;
    foreach ($words as $key => $valor) {
        if ($valor['p'] < $puntos) {
            return false;
        }

        if (isset($valor['w'][$tengoC])) continue;

        foreach ($valor['c'] as $letra => $cuantas) {
            if (!isset($tengo[$letra]) || $tengo[$letra] < $cuantas) {
                continue 2;
            }
        }

        return $key;
    }

    return false;
}

$lines = array_map('trim', file('php://stdin'));
$cases = array_shift($lines);

foreach ($lines as $line) {
    list($fichas, $tablero) = explode(' ', $line);

    $tablero = str_split($tablero);
    usort($tablero, function($a, $b) use ($letterValues) { return ($letterValues[$a] < $letterValues[$b]) ? 1 : -1;});
    $tablero = implode('', array_unique($tablero));
    $puntos = 0;
    $tirada = 'ZZZZZZZ';
    $fichasArr = array();
    for ($i = 0; $i < strlen($tablero); $i++) {
        $fichasArr = str_split($fichas);
        $fichasArr[] = $tablero[$i];
        $tiradaPos = mejorPalabra($fichasArr, $puntos);
        if (!empty($tiradaPos) && ($words[$tiradaPos]['p'] > $puntos || ($words[$tiradaPos]['p'] == $puntos && $words[$tiradaPos]['w'] < $tirada))) {
            $tirada = $words[$tiradaPos]['w'];
            $puntos = $words[$tiradaPos]['p'];
        }
    }

    echo $tirada . ' ' . $puntos . PHP_EOL;
}
