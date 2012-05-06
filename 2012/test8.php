#!/opt/local/bin/php
<?php

$lines = array_map('trim', file('php://stdin'));

$original = array_shift($lines);
$read = '/tmp/prob8_original';
$process = '/tmp/prob8_clones';

file_put_contents($read, $original);

foreach ($lines as $key => $line)
{
    $fdr = fopen($read, 'r');
    $fdp = fopen($process, 'w');

    $transf = explode(',', $line);
    $ors = array(); $dests = array();
    $i = 0;
    $trans = array();
    foreach ($transf as $t) {
        list($or, $dest) = explode('=>', $t);
        $trans[$or] = $dest;
    }

    $dest = '';
    $pieces = 10000000;

    while (!feof($fdr)) {
        $tmp = fread($fdr, $pieces);
        fwrite($fdp, strtr($tmp, $trans));
    }

    fclose($fdr);
    fclose($fdp);

    unlink($read);
    rename($process, $read);
}

echo md5_file($read) . PHP_EOL;