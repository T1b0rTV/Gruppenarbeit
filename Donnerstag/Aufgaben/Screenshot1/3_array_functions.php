<?php
// 3. Array-Funktionen: array_filter + array_map
$numbers = range(1, 10);
// gerade Zahlen filtern
$even = array_filter($numbers, function($n){ return $n % 2 === 0; });
// quadrieren
$squared = array_map(function($n){ return $n * $n; }, $even);

echo "Numbers: "; print_r($numbers);
echo "Even: "; print_r(array_values($even));
echo "Squared: "; print_r(array_values($squared));
?>
