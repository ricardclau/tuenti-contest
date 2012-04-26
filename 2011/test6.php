#!/usr/bin/php
<?php

$problem = file('php://stdin');

$ledsconfig = array(
   0 => 6,	
   1 => 2,	
   2 => 5,
   3 => 5,
   4 => 4,
   5 => 5,	
   6 => 6,	
   7 => 3,
   8 => 7,
   9 => 6,
);

foreach($problem as $i) {	
	$i = trim($i);
	$leds = 0;
	for($j=0; $j <= $i; $j++) {
		$mask = gmdate('His', $j);
		$tmpleds = 0;
		$maskarr = str_split($mask);
		
		for($k = 0; $k < 6; $k++) {
			$tmpleds += $ledsconfig[(int)$maskarr[$k]];
		}
		
		$leds += $tmpleds;
	}
	echo $leds . PHP_EOL;
}