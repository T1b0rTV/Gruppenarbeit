<?php
require_once __DIR__ . '/db_connect.php';

$pdo = getPDO();

$term = '';
$params = [];

if (!empty($_GET['q'])) {
    $term = trim($_GET['q']);
    // search by productName (Bezeichner)
    $sql = "SELECT productCode, productName, productLine, productScale, buyPrice FROM products WHERE productName LIKE :q ORDER BY productName LIMIT 200";
    $params = [':q' => "%$term%"];
} else {
    $sql = "SELECT productCode, productName, productLine, productScale, buyPrice FROM products ORDER BY productName LIMIT 200";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Suche - Classic Models</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Produkte durchsuchen</h1>
    <nav>
      <a href="index.php">Start</a> |
      <a href="search.php">Suche</a> |
      <a href="create.php">Anlegen</a>
    </nav>
  </header>
  <main>
    <form method="get" action="search.php">
      <label for="q">Bezeichner suchen:</label>
      <input id="q" name="q" value="<?= htmlentities($term) ?>" placeholder="z.B. Corvette">
      <button type="submit">Suchen</button>
      <button type="button" onclick="window.location='search.php'">Alle anzeigen</button>
    </form>

    <section>
      <h2>Ergebnisse (<?= count($rows) ?>)</h2>
      <?php if (count($rows) === 0): ?>
        <p>Keine Treffer.</p>
      <?php else: ?>
        <table>
          <thead>
            <tr><th>Code</th><th>Bezeichner</th><th>Linie</th><th>Scale</th><th>Preis</th></tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r): ?>
              <tr>
                <td><?= htmlentities($r['productCode']) ?></td>
                <td><?= htmlentities($r['productName']) ?></td>
                <td><?= htmlentities($r['productLine']) ?></td>
                <td><?= htmlentities($r['productScale']) ?></td>
                <td><?= htmlentities($r['buyPrice']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>
