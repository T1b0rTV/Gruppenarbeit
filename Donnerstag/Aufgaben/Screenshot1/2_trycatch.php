<?php
// 2. Fehlerbehandlung mit try-catch
$filename = __DIR__ . '/nonexistent.txt';
try {
    if (!file_exists($filename)) {
        throw new RuntimeException("Datei nicht gefunden: $filename");
    }
    $content = file_get_contents($filename);
    echo $content;
} catch (Throwable $e) {
    echo "Fehler: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . PHP_EOL;
    // hier könnte man zusätzlich in ein Log schreiben
}
?>
