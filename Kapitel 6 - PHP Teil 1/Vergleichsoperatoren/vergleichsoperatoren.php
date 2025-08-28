<!
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vergleichsoperatoren</title>
</head>
<body>
<?php
// Vergleichsoperatoren, vergleichen Werte miteinander
// diese Werte können auch wieder in einer Variablen abgelegt/zugewiesen werden
$zahl1 = 5;
$zahl2 = "5";

// Die == - "einfache" Gleichheit überprüft nur den Wert und führt dazu auch wenn nötig
// ein Typecasting (Typumwandlung) durch
$wahrheitswert1 = $zahl1 == $zahl2;
var_dump($wahrheitswert1);
echo "<br>";
echo "$wahrheitswert1 <br>";

// != Hier wird auf ungleichheit geprüft und der Wert entsprechend in der Variablen für den
// Wahrheitswert abgelegt. Wie bei der einfachen Gleichheit wird auch hier ein Typecasting
// durchgeführt wenn nötig
$wahrheitswert2 = $zahl1 != $zahl2;
var_dump($wahrheitswert2);
echo "<br>";
echo "$wahrheitswert2 <br>";

// Die === - "strenge" Gleichheit überprüft ebenfalls den Datentyp ohne eine Typenwandlung
$wahrheitswert3 = $zahl1 === $zahl2;
var_dump($wahrheitswert3);
echo "<br>";
echo "$wahrheitswert3 <br>";

// !== Hier wird auf eine Typenumwandlung verzichtet
$wahrheitswert4 = $zahl1 !== $zahl2;
var_dump($wahrheitswert4);
echo "<br>";
echo "$wahrheitswert4 <br>";


?>

</body>
</html><?php
