<?php

$n = 5;
a($n);
b($n);

function a($n)
{
    echo "\nnumber 1(a)\n\n";
    for ($i = 0; $i <= $n; $i++) {
        for ($j = $n - $i; $j >= 1; $j--) {
            echo "$j ";
        }
        echo "\n";
    }
}

function b($n)
{
    echo "\nnumber 1(b)\n\n";

    for ($i = 0; $i < $n; $i++) {
        echo "#";
    }
}
