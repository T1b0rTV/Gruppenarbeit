<?php
// 4. Rekursive Funktion: fakultaet
function fakultaet(int $n): int {
    if ($n < 0) throw new InvalidArgumentException('Negatives n nicht erlaubt');
    if ($n === 0) return 1;
    return $n * fakultaet($n - 1);
}

echo "5! = " . fakultaet(5) . PHP_EOL;
?>
