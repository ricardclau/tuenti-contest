#!/usr/bin/php
<?php

$lines = file('php://stdin');

foreach($lines as $line) {
	$strs = explode(' ', trim($line));
	if(strlen($strs[0]) < strlen($strs[1])) {
		$short = $strs[0];
		$long = $strs[1];
	} else {
		$short = $strs[1];
		$long = $strs[0];
	}
	
	$len = strlen($short);
	for($i = $len; $i >= 0; $i--) {
		for($j = $len; $j >= $i; $j--) {
			if(strpos($long, substr($short, $j-$i, $i)) !== false) {
				break 2;
			}
		}
	}
	
	echo substr($short, $j-$i, $i). PHP_EOL;
}