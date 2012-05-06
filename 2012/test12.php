#!/opt/local/bin/php
<?php

$imgName = 'CANTTF.png';

function _bin2asc($str)
{
    $len = strlen($str);

    $data = array();
    for ($i=0;$i<$len;$i+=8){
        $ch=bindec(substr($str,$i,8));

        $data[]=$ch;

    }
    return $data;
}

function decod($i)
{
    $tx=imagesx($i);
    $ty=imagesy($i);

    $ty=3;

    $data='';
    for ($y=0; $y<$ty; $y++)
    {
        for ($x=0; $x<$tx; $x++)
        {
            $cdat=getcolor($i, $x, $y);

            $data.=($cdat[2]&1).($cdat[1]&1).($cdat[0]&1);
        }
    }
    return $data;
}

// Esta función cogerá las componentes RGB del pixel situado en
// $x, $y
function getcolor($img, $x, $y)
{
    $rgb = imagecolorat($img, $x, $y);
    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;

    return array($b, $g, $r);
}


$img=imagecreatefrompng($imgName);

$d=decod ($img);

$b=_bin2asc($d);

$frase='';
for ($i=0; $i<count($b); $i++)
    $frase.=chr($b[$i]);
// En $frase hay un hash...
// echo substr($frase, 0, 32);
$line = trim(file_get_contents('php://stdin'));

//$line = '1ee7453658914cd7463B77032fdbb623';
// Pista: lsbqrmd -> a90365a5c53eb8a9d03b6a248d894c5a

// Sacado de los LSB -> 62cd275989e78ee56a81f0265a87562e
$keys[0] = substr($frase, 0, 32);
// Lectura del QR
$keys[1] = 'ed8ce15da9b7b5e2ee70634cc235e363';
// md5_file key not being used! Tuenti trying to fool me!
// This is read by opening the file with VI
$keys[2] = 'a541714a17804ac281e6ddda5b707952';
$keys[3] = $line;

$digits = 32;

for ($i = 0; $i < $digits; $i++) {
    $k = 0;
    foreach ($keys as $key) {
        $k += (int) base_convert($key[$i], 16, 10);
    }
    echo base_convert((string) ($k % 16), 10, 16);
}
echo PHP_EOL;



