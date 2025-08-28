<?php
// 4. String-Manipulation
$s = "Hallo Welt";
$lower = mb_strtolower($s, 'UTF-8');
$len = mb_strlen($s, 'UTF-8');
echo "Klein: $lower\nLänge: $len\n";
?>
