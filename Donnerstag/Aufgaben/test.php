<h1>Aufgabe 3  Formularverarbeitung</h1>
    <!-- HTML-Formular -->
    <form method="get">
    <label for="name">Dein Name:</label>
    <input type="text" id="name" name="name" required>
    <button type="submit">Absenden</button>
    </form>
    <?php
    // Formular verarbeiten

    // Prüfen, ob der Parameter gesetzt ist, um Notices zu vermeiden
    if (isset($_GET['name'])) {
        // Kurz trimmen und HTML-spezielle Zeichen escapen, um XSS zu verhindern
        $name = trim($_GET['name']);
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        echo "<h2>Hallo, $name!</h2>";
    }
?>
 