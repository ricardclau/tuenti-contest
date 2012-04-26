#!/usr/bin/php
<?php
ini_set('xdebug.max_nesting_level', 10000);

$zip = zip_open('in.zip');
do {
    $entry = zip_read($zip);
} while ($entry && zip_entry_name($entry) != 'in');

zip_entry_open($zip, $entry, 'r');
$entry_content = zip_entry_read($entry, zip_entry_filesize($entry));

$lines = explode(PHP_EOL, $entry_content);
unset($entry_content);

$tasks = array();
for($i = 4; $i < $lines[1] + 4; $i++) {
    list($id, $time) = explode(',', $lines[$i]);
    $tasks[$id] = array('time' => $time);    
}

$total = count($lines);

for($i = $lines[1] + 6; $i < $total; $i++) {
    $data = explode(',', $lines[$i]);
    $id = array_shift($data);
    $tasks[$id]['depend'] = $data;
}

$input = file('php://stdin');
foreach(explode(',', trim($input[0])) as $in) {
    echo $in . ' ' . calculaTiempo((int)$in, $tasks) . PHP_EOL;
}


function calculaTiempo($in, $tasks) {
    
    if(!isset($tasks[$in]['depend'])) return $tasks[$in]['time'];
    else {
        $total = (int)$tasks[$in]['time'];
        $timesdepend = array();
        foreach($tasks[$in]['depend'] as $depend) {
            $timesdepend[] = (int)calculaTiempo((int)$depend, $tasks);
        }         
        return $total + max($timesdepend);
    }
}