<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="style.php">
</head>
<body>
<div class="gradient-box">
<?php

// Funktionen

// Globaler "Scope"
$begruessung = "Hallo aus dem Globalen Geltungsbereich!";

$name1 = "Peter";
$name2 = "Silke";

echo $begruessung . " " . $name1 . "<br>";
echo $begruessung . " " . $name2 . "<br>";

// Funktionen werden mit dem Schlüsselwort function eingeleitet
// Funktionsbezeichner benötigen KEIN $-Zeichen
function meineBegruessung($name) {
    $begruessung = "Hallo aus einer Funktion!";
    echo $begruessung . " " . $name;
}

meineBegruessung("Hans");
echo "<br>";

$a = 5;
$b = 2;

function summe() {

    // Mit dem Schlüsselwort global kann ich Variablen aus dem
    // Globalen "Scope" in meinem Funktions-Scope verfügbar machen
    global $a, $b;
    return $a + $b;
}

echo summe();



?>
</div>
</body>
</html>