#!/usr/bin/php
<?php

function decode($str) {
    $str = trim($str, '^$');
    $arg = explode(' ', $str);
    
    if(!isset($arg[2])) {
        $arg[2] = $arg[1];
        $arg[1] = 0;
    }
            
    switch($arg[0]) {
        case '=':
            return ($arg[1] + $arg[2]);
        case '#':
            return ($arg[1] * $arg[2]);
        case '@':
            return ($arg[1] - $arg[2]);
    }
}

$lines = file('php://stdin');

foreach($lines as $line) {
    $line = trim($line);
    while(preg_match('/\^[=|#|@]+ [-?\d]+( [-?\d]+)?\$/', $line, $matches) == true) {
        $line = str_replace ($matches[0], decode($matches[0]), $line);        
    }
    echo $line .PHP_EOL;    
}
