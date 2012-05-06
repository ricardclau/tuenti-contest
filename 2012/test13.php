#!/opt/local/bin/php
<?php

$lines = array_map('trim', file('php://stdin'));

function gcm($a, $b)
{
    return ($b == 0) ? ($a) : (gcm($b, $a % $b));
}

function lcm($a, $b)
{
    return ($a / gcm($a, $b)) * $b;
}

function lcm_nums($ar)
{
    if (count($ar) > 1) {
        $ar[] = lcm(array_shift($ar), array_shift($ar));
        return lcm_nums($ar);
    } else {
        return $ar[0];
    }
}


$cases = array_shift($lines);

foreach ($lines as $key => $line) {
    list($numcards, $firstCards) = explode(' ', $line);

    $mapping = array();
    if ((int) $firstCards <= $numcards / 2) {
        for ($i = 0; $i < $firstCards; $i++) {
            $mapping[$i] = 2 * ($firstCards - (1 + $i));
            $mapping[$i + $numcards - $firstCards] = $mapping[$i] + 1;
        }
        for ($i = $firstCards; $i < ($numcards - $firstCards); $i++) {
            $mapping[$i] = $numcards - $i + $firstCards - 1;
        }
    } else {
        $mapping = array();
        for ($i = 0; $i < (2 * $firstCards - $numcards); $i++) {
            $mapping[$i] = $numcards - 1 - $i;
        }
        for (; $i < $firstCards; $i++) {
            $mapping[$i] = 2 * ($firstCards - 1 - $i);
            $mapping[$i + ($numcards - $firstCards)] = $mapping[$i] + 1;
        }
    }

    $mixes = array();
    for ($i = 0; $i < $numcards; $i++) {
        $tmpMixes = 0;

        $originalPos = $i;
        $newPos = $mapping[$originalPos];
        $tmpMixes = 1;
        while ($newPos != $originalPos) {
            $newPos = $mapping[$newPos];
            $tmpMixes++;
        }

        if ($tmpMixes > 1)
            $mixes[$i] = $tmpMixes;
    }

    $mixes = array_unique($mixes);

    if (empty($mixes)) {
        echo 'Case #' . ($key + 1) . ': 1' . PHP_EOL;
    } elseif (count($mixes) == 1) {
        echo 'Case #' . ($key + 1) . ': ' . $mixes[0] . PHP_EOL;
    } else {
        echo 'Case #' . ($key + 1) . ': ' . lcm_nums($mixes) . PHP_EOL;
    }
}
