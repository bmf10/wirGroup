<?php

$number = "1.345.679";
generate($number);

function generate($n)
{
    $intdata = (int) str_replace('.', '', $n);
    $count = strlen($intdata);

    for ($i = 0; $i < $count; $i++) {
        $temp = (int) $intdata - (int) substr($intdata, $i + 1);
        echo substr($temp, 0 + $i) . "\n";
    }
}
