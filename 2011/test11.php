#!/usr/bin/php
<?php

$lines = file('php://stdin');

$lines = array_map('trim', $lines);

$testcases = $lines[0];

for($i = 0; $i < $testcases; $i++) {
	$tests[] = array(
		'max' => $lines[4*$i + 1],
		'total' => $lines[4*$i + 2],
		'stations' => $lines[4*$i + 3],
		'dists' => $lines[4*$i + 4],
		);
}

foreach($tests as $test) {
	echo getStops($test) . PHP_EOL;
}

function getStops($test) {
	$max = $test['max'];
	$total = $test['total'];
	$stations = $test['stations'];
	$dists = explode(' ', $test['dists']);
	
	if($max >= $total) return 'No stops';
	$out = '';
	$distalready = 0;
	for($i = 0; $i < $stations - 1; $i++) {
		if($dists[$i + 1] - $distalready > $max) {
			$out .= $dists[$i]. ' ';
			$distalready = $dists[$i];
		}
	}
	
	return trim($out);
}