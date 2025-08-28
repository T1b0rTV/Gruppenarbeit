<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>PHP-Taschenrechner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .calculator {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .calculator h2 {
            text-align: center;
            color: #333;
        }
        .calculator form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .calculator input[type="number"], 
        .calculator select, 
        .calculator input[type="submit"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .calculator input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .calculator input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        .result {
            margin-top: 15px;
            padding: 10px;
            background-color: #e9e9e9;
            border-radius: 4px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="calculator">
    <h2>Taschenrechner</h2>
    <form action="" method="post">
        <input type="number" name="wert1" step="any" placeholder="Erster Wert" required>
        <select name="operator" required>
            <option value="add">+</option>
            <option value="subtract">-</option>
            <option value="multiply">*</option>
            <option value="divide">/</option>
        </select>
        <input type="number" name="wert2" step="any" placeholder="Zweiter Wert" required>
        <input type="submit" value="Berechnen">
    </form>

    <?php
    // Überprüfen, ob das Formular gesendet wurde
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Funktionen für die Grundrechenarten
        function addiere($a, $b) {
            return $a + $b;
        }
        function subtrahiere($a, $b) {
            return $a - $b;
        }
        function multipliziere($a, $b) {
            return $a * $b;
        }
        function dividiere($a, $b): float|string {
            // Vermeidung einer Division durch Null
            if ($b != 0) {
                return $a / $b;
            } else {
                return "Fehler: Division durch Null nicht möglich.";
            }
        }

        // Werte aus dem Formular abrufen und in Fließkommazahlen umwandeln
        $wert1 = floatval($_POST["wert1"]);
        $wert2 = floatval($_POST["wert2"]);
        $operator = $_POST["operator"];
        $ergebnis = "";

        // Berechnung je nach gewähltem Operator
        switch ($operator) {
            case "add":
                $ergebnis = addiere($wert1, $wert2);
                break;
            case "subtract":
                $ergebnis = subtrahiere($wert1, $wert2);
                break;
            case "multiply":
                $ergebnis = multipliziere($wert1, $wert2);
                break;
            case "divide":
                $ergebnis = dividiere($wert1, $wert2);
                break;
            default:
                $ergebnis = "Ungültiger Operator.";
        }
        
        // Ergebnis anzeigen
        echo "<div class='result'>Ergebnis: " . $ergebnis . "</div>";
    }
    ?>
</div>

</body>
</html>