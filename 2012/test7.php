#!/opt/local/bin/php
<?php

$lines = array_map('trim', file('php://stdin'));

function permute($str) {
    /* If we only have a single character, return it */
    if (strlen($str) < 2) {
        return array($str);
    }
    /* Initialize the return value */
    $permutations = array();
    /* Copy the string except for the first character */
    $tail = substr($str, 1);
    /* Loop through the permutations of the substring created above */
    foreach (permute($tail) as $permutation) {
        $length = strlen($permutation);
        /* Loop through the permutation and insert the first character of the original
        string between the two parts and store it in the result array */
        for ($i = 0; $i <= $length; $i++) {
            $permutations[] = substr($permutation, 0, $i) . $str[0] . substr($permutation, $i);
        }
    }
    /* Return the result */
    return $permutations;
}

function isPermValid($perm, $lines) {
   foreach ($lines as $line) {
      for ($k = 0; $k < strlen($line) - 1; $k++) {
          if (strpos($perm, $line[$k]) > strpos($perm, $line[$k+1])) {
              return false;
          }
      }
   }

   return true;
}

$uniqueChars = count_chars(implode('', $lines), 3);
$possib = permute($uniqueChars);

$valid = array();
foreach ($possib as $pos) {
    if (isPermValid($pos, $lines)) {
        $valid[] = $pos;
    }
}

sort($valid);

foreach ($valid as $v) {
    echo $v . PHP_EOL;
}