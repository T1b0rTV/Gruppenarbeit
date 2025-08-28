<!
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<?php

$zahl1 = 5;
$zahl2 = "5";

// If - Verzweigung mit "strenger" Gleichheit
if ($zahl1 == $zahl2) {
    echo "Die beiden Zahlen scheinen gleich zu sein";
}

echo "<br>";

// If - Verzweigung mit "strenger" Gleichheit
if ($zahl1 === $zahl2) {
    echo "Die beiden Zahlen haben scheinbar den gleichen Datentyp.";
} else {
    echo "oder auch nicht.";
}

echo "<br>";
// If - Verzweigung mit "strenger" Gleichheit
if ($zahl1 === $zahl2) {
    echo "Die beiden Zahlen haben scheinbar den gleichen Datentyp.";
    // Elseif für alternativen Ablauf mit eigener Bedingung
} elseif ($zahl1 <= $zahl2) {
    echo "Zahl1 scheint kleiner oder gleich Zahl2 zu sein.";
}

echo "<br>";

// Ternärer Operator (ternary operator)
$dreiTeiligerOperator = ($zahl1 > $zahl2) ? "Zahl1 ist größer." : "Zahl1 ist kleiner oder gleich.";
echo $dreiTeiligerOperator . "<br>";

echo "<br>";

$pruefVariable = "Samstag";
switch ($pruefVariable) {
    case "Montag":
    case "Dienstag":
    case "Mittwoch":
    case "Donnerstag":
    case "Freitag":
        echo "Werktag";
        break;
    case "Samstag":
    case "Sonntag":
        echo "Wochenende";
        break;
    default:
        echo "Keiner der anderen Fälle ist eingetreten.";
}

echo "<br>";

?>

</body>
</html>
