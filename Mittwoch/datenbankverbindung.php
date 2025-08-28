
<?php
/**
 * Ein kleines Demo-Skript, das zeigt, wie man die DB-Verbindung nutzt,
 * eine einfache Produktsuche über ein GET-Formular ausführt und die
 * Ergebnisse sicher als HTML-Tabelle ausgibt.
 *
 * Dieses Skript ist bewusst minimal und dient als Lern-/Übungsbeispiel.
 */

require_once __DIR__ . '/db_config.php';

// Minimaler Contract
// - Input: GET parameter 'q' (optional)
// - Output: HTML Seite mit Suchformular und Tabelle der Produkte
// - Error modes: DB-Verbindungsfehler beendet die Seite, sonst freundliche Hinweise

// Suche: bevorzugt POST (sicherer), mit GET-Fallback für direkte Links
$q = '';
if (isset($_POST['q'])) {
    $q = trim((string)$_POST['q']);
} elseif (isset($_GET['q'])) {
    $q = trim((string)$_GET['q']);
}

// Verbindung holen
$conn = getPDO();

$products = [];
//  Wenn möglich entweder POST oder GET aber nicht bedes gleichzeitig!!
$perPage = 10;
$page = 1;
if (isset($_POST['per_page'])) {
    $perPage = max(1, (int)$_POST['per_page']);
} elseif (isset($_GET['per_page'])) {
    $perPage = max(1, (int)$_GET['per_page']);
}
if (isset($_POST['page'])) {
    $page = max(1, (int)$_POST['page']);
} elseif (isset($_GET['page'])) {
    $page = max(1, (int)$_GET['page']);
}
$offset = ($page - 1) * $perPage;

// Is this an AJAX request? frontend posts ajax=1; we accept POST or GET flag for compatibility
$isAjax = (isset($_POST['ajax']) && $_POST['ajax'] == '1') || (isset($_GET['ajax']) && $_GET['ajax'] == '1');

if ($q !== '') {
    // Multi-Term-Suche unterstützen (AND/OR/standard OR)
    $lower = mb_strtolower($q, 'UTF-8');
    if (preg_match('/\band\b/', $lower)) {
        $parts = preg_split('/\s+and\s+/i', $q);
        $op = 'AND';
    } elseif (preg_match('/\bor\b/', $lower)) {
        $parts = preg_split('/\s+or\s+/i', $q);
        $op = 'OR';
    } else {
        $parts = preg_split('/[\s,]+/', $q);
        $op = 'OR';
    }

    $terms = array_values(array_filter(array_map('trim', $parts), function($v){ return $v !== ''; }));

    if (count($terms) > 0) {
        $clauses = array_fill(0, count($terms), 'productName LIKE ?');
        $where = implode(" $op ", $clauses);

        // Count total
        $countSql = "SELECT COUNT(*) AS c FROM products WHERE $where";
        $countStmt = $conn->prepare($countSql);
        $countParams = array_map(function($t){ return '%' . $t . '%'; }, $terms);
        $countStmt->execute($countParams);
        $total = (int)$countStmt->fetchColumn();

        // Select with LIMIT/OFFSET (sichere Casting auf int für LIMIT)
        $sql = "SELECT productCode, productName, productLine, productScale, productVendor, quantityInStock, buyPrice FROM products WHERE $where ORDER BY productName LIMIT " . (int)$offset . "," . (int)$perPage;
        $stmt = $conn->prepare($sql);
        $stmt->execute($countParams);
        $products = $stmt->fetchAll();

        if ($isAjax) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'total' => $total,
                'page' => $page,
                'per_page' => $perPage,
                'results' => $products,
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    } else {
        $total = 0;
    }
} else {
    $total = 0;
}

// Helfer zum Escapen
/**
 * Escaping-Helfer für die HTML-Ausgabe.
 *
 * Warum:
 * - Zentralisiert das HTML-Escaping, damit alle Ausgaben konsistent
 *   und sicher gegen XSS sind.
 *
 * Was sie macht:
 * - Nimmt einen String und gibt eine HTML-escaped Version zurück,
 *   sicher für die Ausgabe in HTML-Textknoten.
 *
 * Input:
 * - string $s : der zu escapende Text
 *
 * Output:
 * - string : sicher escapeter Text
 */
function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?>
<!doctype html>
<html lang="de">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Produkte suchen</title>
        <meta name="description" content="Schnelle, sichere Produkt-Suche für die ClassicModels Demo-Datenbank. Live-Suche, Paging, sichere Abfragen">
        <meta property="og:title" content="Produkt-Suche">
        <meta property="og:description" content="Live-Produkt-Suche mit sicherer PDO-Anbindung">
        <link rel="stylesheet" href="style.css">
    <link rel="icon" href="assets_favicon.svg" type="image/svg+xml">
</head>
<body>
<div class="site">
        <div class="card" role="main" aria-labelledby="page-title">
                    <div class="cta" role="region" aria-label="Intro">
                        <div>
                            <h2 id="page-title">Entdecke Produkte — schnell & sicher</h2>
                            <p>Live-Suche, sichere Datenbankabfragen und professionelle Darstellung.</p>
                        </div>
                    </div>
        <div class="header">
                    <div class="brand">
                        <div class="logo">
                            <?php echo file_get_contents(__DIR__ . '/assets_logo.svg'); ?>
                        </div>
                        <div>
                            <h1>Produkt-Suche</h1>
                            <div class="subtitle">Suche schnell Produkte in der ClassicModels DB</div>
                        </div>
                    </div>
            <div class="meta">DB: classicmodels</div>
        </div>

            <form method="post">
                    <div class="searchRow">
                        <input id="q" name="q" type="text" value="<?= e($q) ?>" placeholder="z. B. renault">
                        <button type="submit" aria-label="Suchen"><svg class="icon" aria-hidden="true"><use xlink:href="#icon-search"></use></svg></button>
                    </div>
        </form>

        <?php if ($q === ''): ?>
                <div class="empty">Bitte gib einen Suchbegriff ein und drücke "Suchen".</div>
        <?php else: ?>
                <div class="meta">Ergebnisse für "<?= e($q) ?>" — <?= count($products) ?> Treffer</div>

                <?php if (count($products) === 0): ?>
                        <div class="empty">Keine Produkte gefunden.</div>
                <?php else: ?>
                        <table>
                                <thead>
                                        <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                                <th>Line</th>
                                                <th>Scale</th>
                                                <th>Vendor</th>
                                                <th>Stock</th>
                                                <th>Preis</th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($products as $p): ?>
                                        <tr>
                                                <td><?= e($p['productCode']) ?></td>
                                                <td><?= e($p['productName']) ?></td>
                                                <td><?= e($p['productLine']) ?></td>
                                                <td><?= e($p['productScale']) ?></td>
                                                <td><?= e($p['productVendor']) ?></td>
                                                <td><?= e((string)$p['quantityInStock']) ?></td>
                                                <td><?= e((string)$p['buyPrice']) ?></td>
                                        </tr>
                                <?php endforeach; ?>
                                </tbody>
                        </table>
                <?php endif; ?>
        <?php endif; ?>

        <div class="footer">Tipp: Mehrere Begriffe mit <code>and</code> / <code>or</code> kombinieren oder einfach Leerzeichen verwenden.</div>
            </div>
        </div>
        <script src="script.js"></script>
        <!-- Inline icon symbols for usage -->
        <?php echo file_get_contents(__DIR__ . '/assets_icons.svg'); ?>
    </body>
    </html>