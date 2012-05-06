#!/opt/local/bin/php
<?php

$lines = array_map('trim', file('php://stdin'));

function decode($str) {
    $arg = explode(' ', $str);

    if (false !== strpos($str, 'breadandfish')) {
        return $arg[0] . ' ' . $arg[0];
    }

    if (false !== strpos($str, 'mirror')) {
       return $arg[0] * -1;
    }

    if (false !== strpos($str, 'dance')) {
        $tmp = $arg[0];
        $arg[0] = $arg[1];
        $arg[1] = $tmp;
        $arg[2] = $arg[3];
    }

    switch ($arg[2]) {
        case '$':
            return $arg[0] - $arg[1];
        case '@':
            return $arg[0] + $arg[1];
        case '#':
            return $arg[0] * $arg[1];
        case 'conquer':
            return $arg[0] % $arg[1];
        case '&':
            return (int) ($arg[0] / $arg[1]);
        case 'fire':
            return $arg[0];
    }
}

foreach ($lines as $line) {
    while (preg_match('/[-?\d]+ breadandfish/', $line, $matches) == true) {
        $line = str_replace($matches[0], decode($matches[0]), $line);
    }

    while (preg_match('/[-?\d]+ ([-?\d]+ )?(dance )?[$|@|&|#|fire|conquer|mirror]+/', $line, $matches) == true) {
        $line = str_replace($matches[0], decode($matches[0]), $line);
    }

    echo trim($line, '. ') . PHP_EOL;
}