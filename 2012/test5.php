#!/opt/local/bin/php
<?php

$lines = array_map('trim', file('php://stdin'));

function ledsWithOldInSecs($secs)
{
    $ledsconfig = array(
        0 => 6,
        1 => 2,
        2 => 5,
        3 => 5,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 3,
        8 => 7,
        9 => 6,
    );

    $leds = 0;
    for ($j = 0; $j <= $secs; $j++) {
        $mask = gmdate('His', $j);
        $tmpleds = 0;
        $maskarr = str_split($mask);

        for($k = 0; $k < 6; $k++) {
            $tmpleds += $ledsconfig[(int)$maskarr[$k]];
        }
        $leds = bcadd($leds, $tmpleds);
    }

    return $leds;
}

function ledsWithEffInSecs($secs)
{
    $ledsconfig = array(
        '0-1' => 0,
        '1-2' => 4,
        '2-3' => 1,
        '3-4' => 1,
        '4-5' => 2,
        '5-6' => 1,
        '6-7' => 1,
        '7-8' => 4,
        '8-9' => 0,
        '9-0' => 1,
        '5-0' => 2, // 59m or 59s -> 00
        '2-0' => 2, // 23h -> 00
        '3-0' => 2, // 23h -> 00
    );

    $leds = 36;
    $antmask = array_fill(0,6,'0');
    for($j = 1; $j <= $secs; $j++) {
        $mask = gmdate('His', $j);
        $maskarr = str_split($mask);

        $tmpleds = 0;
        for($k = 0; $k < 6; $k++) {
            if($antmask[$k] != $maskarr[$k]) {
                $tmpleds += $ledsconfig[$antmask[$k].'-'.$maskarr[$k]];
            }
        }
        $antmask = $maskarr;
        $leds = bcadd($leds, $tmpleds);
    }

    return $leds;
}

$_1diamal = ledsWithOldInSecs(86400);
$_1diabien = ledsWithEffInSecs(86400);

foreach ($lines as $line) {
    list($dateIni, $dateFin) = explode(' - ', $line);
    //var_dump($dateIni, $dateFin); exit();
    $dini = strtotime($dateIni);
    $dfin = strtotime($dateFin);

    $secs = $dfin - $dini;
    $dias = (int) ($secs / 86400);
    $resto = $secs % 86400;

    $old = bcadd(bcmul($dias, $_1diamal), ledsWithOldInSecs($resto));
    $new = bcadd(bcmul($dias, $_1diabien), ledsWithEffInSecs($resto));
    echo bcsub($old, $new) . PHP_EOL;
}