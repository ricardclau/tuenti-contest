#!/usr/bin/php
<?php

$lines = file('php://stdin');

function phplev($s1, $s2, $costadd, $costchange, $costremove) {
	$l1 = strlen($s1);                    // Länge des $s1 Strings
    $l2 = strlen($s2);                    // Länge des $s2 Strings
    $dis = range(0,$l2);                  // Erste Zeile mit (0,1,2,...,n) erzeugen 

	for ($i2 = 0; $i2 <= $l2; $i2++) {
		$dis[$i2] = $i2 * $costadd;
	}
	for ($i1 = 0; $i1 < $l1 ; $i1++) {
		$dis_new[0] = $dis[0] + $costremove;

		for ($i2 = 0; $i2 < $l2; $i2++) {
			$c0 = $dis[$i2] + (($s1[$i1] == $s2[$i2]) ? 0 : $costchange);
			$c1 = $dis[$i2 + 1] + $costremove;
			if ($c1 < $c0) {
				$c0 = $c1;
			}
			$c2 = $dis_new[$i2] + $costadd;
			if ($c2 < $c0) {
				$c0 = $c2;
			}
			$dis_new[$i2 + 1] = $c0;
		}
		$tmp = $dis;
		$dis = $dis_new;
		$dis_new = $tmp;
	}
			
	return $dis[$l2];
}



foreach($lines as $line) {
	$line = trim($line);
	list($str1, $str2, $costs) = explode(' ', $line);
	list($costadd, $costremove, $costchange) = explode(',', $costs);
	
	echo phplev($str1, $str2, $costadd, $costchange, $costremove) . PHP_EOL;
}