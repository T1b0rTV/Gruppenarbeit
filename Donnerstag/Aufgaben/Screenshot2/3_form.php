<?php
// 3. Formularverarbeitung: kleines HTML-Formular + POST-Verarbeitung
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : 'Gast';
    echo "Hallo, " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "!";
    exit;
}
?>
<!doctype html>
<html>
<body>
  <form method="post">
    <label for="name">Name:</label>
    <input id="name" name="name" type="text">
    <button type="submit">Senden</button>
  </form>
</body>
</html>
