<?php

include 'header.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<div>
  <?php
  switch ($page) {
    case 'home':
      echo "<h1>Meine Landingpage</h1>";
      break;
    case 'about':
      echo "<h1>Alle Infos über mich</h1>";
      break;
    case 'contact':
      echo "<h1>Hier kannst du mich erreichen</h1>";
      break;
    default:
      echo "<h1>404-Seite, hier konnte kein Dokument gefunden werden</h1>";
  }

  ?>

</div>



<?php
include 'footer.php';
