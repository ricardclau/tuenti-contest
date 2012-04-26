#!/usr/bin/php
<?php

$lines = file('php://stdin');
foreach($lines as $line) {
    echo array_reduce(preg_split('/\s/', trim($line)), 'bcadd') .  PHP_EOL;
}
