#!/opt/local/bin/php
<?php

$lines = array_map('trim', file('php://stdin'));
$cases = array_shift($lines);

foreach ($lines as $line) {

    list($word, $appearance) = explode(' ', $line);
    $found = 0;
    foreach (scandir('documents') as $doc) {
        if ($doc == '.') continue;
        if ($doc == '..') continue;
        foreach (file('documents/' . $doc) as $doclineNum => $docline) {
            $docline = strtolower($docline);

            if (false === strpos($docline, $word)) {
                continue;
            }

            $doclineWords = preg_split('/\s/', $docline);
            foreach ($doclineWords as $wordpos => $doclineWord) {
                if ($doclineWord == $word) {
                    $found++;
                }
                if ($found == $appearance) {
                    break 3;
                }
            }
        }
    }

    echo (int) $doc . '-' . ($doclineNum + 1) . '-' . ($wordpos + 1) . PHP_EOL;
}
