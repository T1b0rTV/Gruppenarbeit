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
    // Aufgabe 1
    $apfelAnzahl = 12;
    $birnenAnzahl = 8;

    $gesamtFrüchte = $apfelAnzahl + $birnenAnzahl;
    echo "Gesamtanzahl der Früchte: " . $gesamtFrüchte . "<br>";

    // Aufgabe 2
    $stundenLohn = 15.50;
    $gearbeiteteStunden = 40;

    $gesamtVerdienst = $stundenLohn * $gearbeiteteStunden;
    echo "Gesamtverdienst: " . $gesamtVerdienst . " Euro<br>";

    // Aufgabe 3
    $zaehler = 5;

    // Prä-Inkrementierung
    $wert = ++$zaehler;
    echo "Wert nach Prä-Inkrementierung: " . $wert . "<br>";

    // Post-Dekrementierung
    $wert2 = $zaehler--;
    echo "Wert nach Post-Dekrementierung: " . $wert2 . "<br>";

    echo "Finaler Wert des Zählers: " . $zaehler . "<br>";

    // Aufgabe 4
    $begruessung = "Guten";
    $begruessung .= " Morgen!";
    echo $begruessung . "<br>";

    // Aufgabe 5a
    $passwortEingabe = "SecureP@ss";
    $gespeichertesPasswort = "SecureP@ss";
    $sindGleich = $passwortEingabe == $gespeichertesPasswort;
    var_dump($sindGleich);
    $sindUngleich = $passwortEingabe != $gespeichertesPasswort;
    var_dump($sindUngleich);

    echo "<br>";

    // Aufgabe 5b
    $passwortEingabe = "SecureP@sd";
    $gespeichertesPasswort = "SecureP@ss";
    $sindGleich = $passwortEingabe == $gespeichertesPasswort;
    var_dump($sindGleich);
    $sindUngleich = $passwortEingabe != $gespeichertesPasswort;
    var_dump($sindUngleich);

    echo "<br>";

    //Aufgabe 6
    $wertA = 10;
    $wertB = "10";
    $istGleich = $wertA == $wertB;
    var_dump($istGleich);
    $istUngleich = $wertA === $wertB;
    var_dump($istUngleich);

    echo "<br>";

    //Aufgabe 7a
$loggedIn = true;
$isAdmin = true;
$zugriffErlaubt = $loggedIn && $isAdmin;
var_dump($zugriffErlaubt);

echo "<br>";

    //Aufgabe 7b
    $loggedIn = true;
    $isAdmin = false;
    $zugriffErlaubt = $loggedIn && $isAdmin;
    var_dump($zugriffErlaubt);
    ?>
</div>
</body>
</html>