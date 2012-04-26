#!/usr/bin/php
<?php

$problem = file('php://stdin');

foreach($problem as $i) {	
	list($numvacas, $camion, $pesovacas, $lechevacas) = explode(' ', trim($i));
	
	$pesosvacas = explode(',', $pesovacas);
	$prod = explode(',', $lechevacas);
	
	echo getBestCombi($numvacas, $camion, $pesosvacas, $prod) . PHP_EOL;
}

function getBestCombi($numvacas, $camion, $pesosvacas, $prod) {
	$maxprod = 0;
	
	$limit = pow(2, $numvacas);

	for($i = 1; $i < $limit; $i++) {
		$mask = str_pad(decbin($i), $numvacas, '0');
		$test = calculaMask($mask, $camion, $pesosvacas, $prod);
		if($test > $maxprod) $maxprod = $test;
	}	
	return $maxprod;
}

function calculaMask($mask, $camion, $pesosvacas, $prod) {
	$maskarr = str_split($mask);	
	$total = count($maskarr);
	for($i = 0; $i < $total; $i++) {
		if($maskarr[$i] == '0') {
			unset($pesosvacas[$i]);
			unset($prod[$i]);
		}				
	}
	if(array_sum($pesosvacas) > $camion) return 0;
	else return array_sum($prod);
}