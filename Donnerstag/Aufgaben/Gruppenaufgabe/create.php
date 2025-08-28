<?php
session_start();
require_once __DIR__ . '/db_connect.php';
$pdo = getPDO();

// Simple, hard-coded credentials for the exercise.
const USERNAME = 'admin';
const PASSWORD = 'secret';

// Handle login
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    if ($u === USERNAME && $p === PASSWORD) {
        $_SESSION['user'] = USERNAME;
    } else {
        $login_error = 'Ungültige Anmeldedaten';
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: create.php');
    exit;
}

// Handle creation (only when logged in)
if (isset($_POST['action']) && $_POST['action'] === 'create' && isset($_SESSION['user'])) {
    $code = trim($_POST['productCode'] ?? '');
    $name = trim($_POST['productName'] ?? '');
    $line = trim($_POST['productLine'] ?? '');
    $scale = trim($_POST['productScale'] ?? '');
    $price = trim($_POST['buyPrice'] ?? '');

    $errors = [];
    if ($code === '') $errors[] = 'Produktcode ist vereist.';
    if ($name === '') $errors[] = 'Bezeichner ist vereist.';
    if (!is_numeric($price)) $errors[] = 'Preis muss numerisch sein.';

    if (empty($errors)) {
        $sql = "INSERT INTO products (productCode, productName, productLine, productScale, buyPrice) VALUES (:code,:name,:line,:scale,:price)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([':code'=>$code,':name'=>$name,':line'=>$line,':scale'=>$scale,':price'=>$price]);
            $success = 'Produkt erfolgreich angelegt.';
        } catch (PDOException $e) {
            $errors[] = 'DB-Fehler: ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Anlegen - Classic Models</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Neues Produkt anlegen</h1>
    <nav>
      <a href="index.php">Start</a> |
      <a href="search.php">Suche</a> |
      <a href="create.php">Anlegen</a>
    </nav>
  </header>
  <main>
    <?php if (!isset($_SESSION['user'])): ?>
      <section>
        <h2>Anmelden</h2>
        <?php if (!empty($login_error)): ?><p class="error"><?=htmlentities($login_error)?></p><?php endif; ?>
        <form method="post">
          <input type="hidden" name="action" value="login">
          <label>Benutzername <input name="username"></label>
          <label>Passwort <input type="password" name="password"></label>
          <button>Anmelden</button>
        </form>
        <p>Benutzer: <code>admin</code> Passwort: <code>secret</code></p>
      </section>
    <?php else: ?>
      <section>
        <p>Eingeloggt als <?=htmlentities($_SESSION['user'])?> — <a href="?logout=1">Abmelden</a></p>
        <?php if (!empty($success)): ?><p class="success"><?=htmlentities($success)?></p><?php endif; ?>
        <?php if (!empty($errors)): ?><div class="error"><ul><?php foreach ($errors as $e) echo '<li>'.htmlentities($e).'</li>'; ?></ul></div><?php endif; ?>

        <h2>Neues Produkt</h2>
        <form method="post">
          <input type="hidden" name="action" value="create">
          <label>Produktcode <input name="productCode" required></label>
          <label>Bezeichner <input name="productName" required></label>
          <label>Linie <input name="productLine"></label>
          <label>Scale <input name="productScale"></label>
          <label>Preis <input name="buyPrice" required></label>
          <button>Erstellen</button>
        </form>
      </section>
    <?php endif; ?>
  </main>
</body>
</html>
