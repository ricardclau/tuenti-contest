#!/opt/local/bin/php
<?php

$lines = array_map('trim', file('php://stdin'));

$cases = array_shift($lines);
for ($c = 0; $c < $cases; $c++) {
    list($width, $height, $count) = explode(' ', array_shift($lines));
    $message = array_shift($lines);

    $stichesWidth = $width * $count;
    $stichesHeight = $height * $count;

    $charsHeight = 0;
    $messageChars = strlen(str_replace(' ', '', $message));

    $maxCharSize = min($stichesHeight, $stichesWidth);
    for ($charsTest = 1; $charsTest < $maxCharSize; $charsTest++) {
        $filesFitting = $maxCharSize / $charsTest;
        $actualFilesGenerated = count(explode('ñ', wordwrap($message, $stichesWidth / $charsTest, 'ñ')));
        if ($actualFilesGenerated <= $filesFitting)  {
            $charsHeight = $charsTest;
        }
    }

    $length = ($messageChars / (2 * $count)) * $charsHeight * $charsHeight;

    echo 'Case #' . ($c + 1) . ': ' . ceil($length) . PHP_EOL;
}