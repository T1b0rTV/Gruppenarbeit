<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Multiplikationstabelle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 50%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <h1>Multiplikationstabelle (1x1 bis 10x10)</h1>

    <table>
        <?php
            // Äußere Schleife für die Zeilen (von 1 bis 10)
            for ($i = 1; $i <= 10; $i++) {
                echo "<tr>"; // Startet eine neue Zeile
                
                // Innere Schleife für die Spalten (von 1 bis 10)
                for ($j = 1; $j <= 10; $j++) {
                    $ergebnis = $i * $j;
                    echo "<td>" . $ergebnis . "</td>"; // Erzeugt eine Zelle mit dem Ergebnis
                }
                
                echo "</tr>"; // Beendet die Zeile
            }
        ?>
    </table>

</body>
</html>