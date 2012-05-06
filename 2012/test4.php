#!/usr/bin/php
<?php

$lines = array_map('trim', file('php://stdin'));
$testCases = array_shift($lines);


for ($i = 0; $i < $testCases; $i++) {
    $liters = 0;
    $accumPass = 0;
    list($races, $karts, $groups) = explode(' ', array_shift($lines));

    $peopleStack = explode(' ', array_shift($lines));
    $initStack = $peopleStack;
    $cycles = $races;

    $genteTotal = array_sum($peopleStack);
    if ($genteTotal <= $karts) {
        echo ($races * $genteTotal) . PHP_EOL;
        continue;
    }

    $alreadyInspected = array();

    /**
     * Check repetitions
     */
    for ($r = 0; $r < $races; $r++) {
        $racing = 0;
        for ($pass = 0; $pass < $groups; $pass++) {
            if ($racing + $peopleStack[$pass] <= $karts) {
                $racing += $peopleStack[$pass];
            } else {
                break;
            }
        }
        // $liters += $racing;

        $inspectKey = implode(',', array_slice($peopleStack, 0, $pass));
        $existingInspectedKey = array_search($inspectKey, $alreadyInspected);

        if (false === $existingInspectedKey || $accumPass < count($peopleStack)) {
            $alreadyInspected[] = $inspectKey;
        } else {
            break;
        }


        /**
         * Reorder array for next race
         */
        for ($reorders = 0; $reorders < $pass; $reorders++) {
            array_push($peopleStack, array_shift($peopleStack));
        }
        $accumPass += $pass;
    }

    if (false !== $existingInspectedKey && $r < $races) {
        $initLoop = $existingInspectedKey;
        $endLoop = $r;
    } else {
        $initLoop = -1;
        $endLoop = -1;
    }

    $peopleStack = $initStack;
    for ($r = 0; $r < $races; $r++) {

        if ($r == $initLoop) {
            $litersAccum = 0;
            $accum = true;
        }

        if ($r == $endLoop) {
            $accum = false;
            $loopSize = $endLoop - $initLoop;
            $totalLoops = (int) (($races - $initLoop) / $loopSize);

            if ($totalLoops > 1) {
                $liters += ($totalLoops - 1) * $litersAccum;
                $r += (($totalLoops - 1) * $loopSize) - 1;
                continue;
            }
        }

        $racing = 0;
        /**
         * How many people is racing?
         */
        for ($pass = 0; $pass < $groups; $pass++) {
            if ($racing + $peopleStack[$pass] <= $karts) {
               $racing += $peopleStack[$pass];
            } else {
                break;
            }
        }

        if ($accum == true) {
            $litersAccum += $racing;
        }

        $liters += $racing;
        /**
         * Reorder array for next race
         */
        for ($reorders = 0; $reorders < $pass; $reorders++) {
            array_push($peopleStack, array_shift($peopleStack));
        }
    }

    echo $liters . PHP_EOL;
}
