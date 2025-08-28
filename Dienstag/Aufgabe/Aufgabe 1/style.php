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
width: 300px;
height: 300px;
/* Diagonal von links oben nach rechts unten */
background: linear-gradient(to bottom right, <?php echo $startColor; ?>, <?php echo $middleColor; ?>, <?php echo $endColor; ?>);
border-radius: 10px;
margin: 20px;
}

.gradient-box2 {
width: 245px;
height: 45px;
/* Diagonal von links oben nach rechts unten */
background: linear-gradient(to bottom right, <?php echo $startColor; ?>, <?php echo $middleColor; ?>, <?php echo $endColor; ?>);
border-radius: 5px;
margin: 10px;
padding: 5px;
}

h1 {
color: <?php echo $mainColor; ?>;
}

.tg {
          border-collapse: collapse;
          border-spacing: 0;
        }
        .tg td {
          font-family: Arial, sans-serif;
          font-size: 14px;
          padding: 20px 20px;
          border-style: solid;
          border-width: 1px;
          overflow: hidden;
          word-break: normal;
        }
        .tg th {
          font-family: Arial, sans-serif;
          font-size: 14px;
          font-weight: normal;
          padding: 20px 20px;
          border-style: solid;
          border-width: 1px;
          overflow: hidden;
          word-break: normal;
        }
        .tg .tg-jhgd {
          background-color: #3166ff;
        }
        .tg .tg-9wr8 {
          font-size: 13px;
          background-color: #333333;
        }
        .tg .tg-t3k2 {
          background-color: #999903;
        }
        .tg .tg-b286 {
          background-color: #f56b00;
        }