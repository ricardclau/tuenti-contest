#!/usr/bin/php
<?php
$ledsconfig = array(
   '0-1' => 0,	
   '1-2' => 4,	
   '2-3' => 1,
   '3-4' => 1,
   '4-5' => 2,
   '5-6' => 1,	
   '6-7' => 1,	
   '7-8' => 4,
   '8-9' => 0,
   '9-0' => 1,
   '5-0' => 2, // 59m or 59s -> 00 
   '2-0' => 2, // 23h -> 00
);

$problem = file('php://stdin');
$problem = array_map('trim', $problem);

foreach($problem as $i) {	
        $leds = 36;
        $antmask = array_fill(0,6,'0');
	for($j=1; $j <= $i; $j++) {
		$mask = gmdate('His', $j);
		$maskarr = str_split($mask);
		
                $tmpleds = 0;
		for($k = 0; $k < 6; $k++) {
                    if($antmask[$k] != $maskarr[$k]) {
                        $tmpleds += $ledsconfig[$antmask[$k].'-'.$maskarr[$k]];
                    }    
		}
		$antmask = $maskarr;
                $leds += $tmpleds;
	}
	echo $leds . PHP_EOL;
}