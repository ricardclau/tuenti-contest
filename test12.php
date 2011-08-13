#!/usr/bin/php
<?php

function BELLMAN_FORD($edges, $edgecount, $nodecount, $source)
{
    // Initialize distances
    $distances = array();

    // This is the INITIALIZE-SINGLE-SOURCE function.
    for($i = 0; $i < $nodecount; ++$i)
        $distances[$i] = INF; // All distances should be set to INFINITY

    $distances[$source] = 0; // The source distance should be set to 0.

    // Do what we are suppose to do, This is the BELLMAN-FORD function
    for($i = 0; $i < $nodecount; ++$i)
    {
        $somethingChanged = false; // If nothing has changed after one pass, it will not change after two.
        for($j = 0; $j < $edgecount; ++$j)
        {
            if($distances[$edges[$j][0]] != INF) // Check so we are not doing something stupid
            {
                $newDist = $distances[$edges[$j][0]] + $edges[$j][2]; // Just create a temporary variable containing the calculated distance
                if($newDist < $distances[$edges[$j][1]]) // If the new distance is shorter than the old one, we've found a new shortest path
                {
                    $distances[$edges[$j][1]] = $newDist;
                    $somethingChanged = true; // SOMETHING CHANGED, YEY!
                }
            }
        }
        // If $somethingChanged == FALSE, then nothing has changed and we can go on with the next step.
        if(!$somethingChanged) break;
    }

    // Check the graph for negative weight cycles
    for($i = 0; $i < $edgecount; ++$i)
    {
        if($distances[$edges[$i][1]] > $distances[$edges[$i][0]] + $edges[$i][2])
        {
            //echo "Negative edge weight cycle detected!";
            return NULL;
        }
    }

    // Print out the shortest distance
    for($i = 0; $i < $nodecount; ++$i)
    {
        // echo "Shortest distance between nodes " . $source . " and " . $i . " is " . $distances[$i] . "<br/>";
    }

    return $distances;
}


$lines = file('php://stdin');

$lines = array_map('trim', $lines);

foreach($lines as $numline => $line) {
    $data = preg_split('/\s/', $line);
    $numplanets = array_shift($data);
    $earth = array_shift($data); 
    $atlantis = array_shift($data);
    $neighbors = array();
    foreach($data as $coord) {
        $points = explode(',', $coord);
        if(count($points) != 3) { continue;}
        
        $neighbors[] = $points; 
    }
    
    
    $paths = BELLMAN_FORD($neighbors, count($neighbors), $numplanets, $earth);
    
    if(!isset($paths[$atlantis]) || $paths[$atlantis] === INF) echo 'BAZINGA'. PHP_EOL;
    else echo (25000 + $paths[$atlantis]) . PHP_EOL;
     
}
