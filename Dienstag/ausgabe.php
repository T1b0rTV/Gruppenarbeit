<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Ausgabe</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #ff7e5f, #feb47b, #86a8e7);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .box {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            font-size: 20px;
            min-width: 300px;
        }
    </style>
</head>

<body>
    <div class="box">
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $vorname   = htmlspecialchars($_POST["vorname"]);
            $nachname  = htmlspecialchars($_POST["nachname"]);
            $email     = htmlspecialchars($_POST["email"]);
            $browser   = htmlspecialchars($_POST["browser"]);
            $gefaellt  = isset($_POST["gefaellt"]) ? $_POST["gefaellt"] : "Keine Angabe";
            $vorschlag = htmlspecialchars($_POST["verbesserung"]);
            $newsletter = isset($_POST["newsletter"]) ? "Ja" : "Nein";

            echo "<p><b>Hallo $vorname $nachname</b></p>";
            echo "<p>Deine E-Mail ist: <b>$email</b></p>";
            echo "<p>Browser: $browser</p>";
            echo "<p>Gefällt dir unsere Website? $gefaellt</p>";
            echo "<p>Verbesserungsvorschläge: $vorschlag</p>";
            echo "<p>Newsletter: $newsletter</p>";
        }
        ?>
    </div>
</body>

</html>