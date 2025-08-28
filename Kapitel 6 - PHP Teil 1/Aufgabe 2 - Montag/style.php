<?php
header("Content-type: text/css");
$mainColor = "#black";
$fontSize = "30px";
$font = "Comic-sans";
$startColor = "#ff7e5f";  // Koralle
$middleColor = "#feb47b"; // Orange
$endColor = "#86a8e7";    // Hellblau
?>

body {
font-family: Verdana, sans-serif;
color: <?php echo $mainColor; ?>;
font-size: <?php echo $fontSize; ?>;
font-family: <?php echo $font; ?>;
margin: 20px;
}

.gradient-box {
width: 750px;
height: 450px;
/* Diagonal von links oben nach rechts unten */
background: linear-gradient(to bottom right, <?php echo $startColor; ?>, <?php echo $middleColor; ?>, <?php echo $endColor; ?>);
border-radius: 10px;
margin: 20px;
}

h1 {
color: <?php echo $mainColor; ?>;
}