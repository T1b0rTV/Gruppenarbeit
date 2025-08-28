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
    $gruß = "Hallo Welt!";
    echo $gruß;

    $alter = 32;
    echo "<br>Ich bin " . $alter . " Jahre alt.";

    $zahl1 = 5;
    $zahl2 = 3;
    $summe = $zahl1 + $zahl2;
    echo "<br>Die Summe von " . $zahl1 . " und " . $zahl2 . " ist " . $summe . ".";

    $name = "Tibor";
    $nachricht = "Hallo, mein Name ist $name und ich bin $alter Jahre alt.";
    echo "<br>" . $nachricht;

    $istSonnig = true;
    $wetterNachricht = $istSonnig ? "Es ist ein sonniger Tag!" : "Es ist kein sonniger Tag.";
    echo "<br>" . $wetterNachricht;
    echo "<br>";
    $punktezahl = 10;
    echo $punktezahl + 5;
    echo "<br>";

    $preis = 2.50;
    $menge = 3;
    $gesamtpreis = $preis * $menge;
    echo "Der Gesamtpreis für " . $menge . " Artikel zu je " . $preis . " Euro beträgt " . $gesamtpreis . " Euro.";
    echo "<br>";

    $leereVariable = null;
    var_dump($leereVariable);
    echo "<br>";
    $produkt = "Apfel";
    $anzahl = 10;

    echo "Sie haben " . $anzahl . " " . $produkt . ".";

    $stadt = "Tokyo";
    $temperatur = 29;
    echo "<br>In " . $stadt . " beträgt die Temperatur " . $temperatur . "°C.";
    ?>
</div>
</body>
</html>