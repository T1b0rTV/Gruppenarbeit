<?php
// 1. Funktion mit Rückgabewert: istPrimzahl
function istPrimzahl(int $n): bool {
    if ($n <= 1) return false;
    if ($n <= 3) return true;
    if ($n % 2 === 0) return false;
    $r = (int)floor(sqrt($n));
    for ($i = 3; $i <= $r; $i += 2) {
        if ($n % $i === 0) return false;
    }
    return true;
}

$test = 13;
echo "Test: $test -> ";
var_export(istPrimzahl($test));
echo PHP_EOL;
?>
