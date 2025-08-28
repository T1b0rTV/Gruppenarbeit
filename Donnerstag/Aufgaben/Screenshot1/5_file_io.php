<?php
// 5. Datei lesen und schreiben
$in = __DIR__ . '/input.txt';
$out = __DIR__ . '/output.txt';
if (!file_exists($in)) {
    file_put_contents($in, "Dies ist ein Beispieltext.\nzweite zeile.");
}
$contents = file_get_contents($in);
$upper = mb_strtoupper($contents, 'UTF-8');
file_put_contents($out, $upper);
echo "Wurde geschrieben: " . basename($out) . PHP_EOL;
?>
