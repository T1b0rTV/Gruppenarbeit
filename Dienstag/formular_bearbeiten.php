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
        if(isset($_GET['vorname'])) {
            $vorname = $_GET['vorname'];
        } else {
            $vorname = "Du hast keinen Vornamen versendet!";
        }
        if(isset($_GET['nachname'])) {
            $nachname = $_GET['nachname'];
        } else {
            $nachname = "Es gibt auch keinen Nachnamen!";
        }
        if(isset($_GET['email'])) {
            $email = $_GET['email'];
        } else {
            $email = "Die E-Mail hat es auch nicht geschafft!";
        }
        if(isset($_GET['vorname'])) {
            echo "Hallo $vorname $nachname, deine E-Mail ist: $email";
        } else {
            echo "$vorname <br> $nachname <br> $email";
        }
    ?>
</div>
</body>
</html>