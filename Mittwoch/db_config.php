<?php
// Kleine DB-Konfiguration mit Funktion, sodass andere Skripte die Verbindung wiederverwenden können.
/**
 * Liefert eine konfigurierte PDO-Instanz für die Anwendung.
 *
 * Warum:
 * - Kapselt die Verbindungsdetails an einer Stelle, damit mehrere Skripte
 *   dieselbe Logik nutzen können (DRY).
 * - Ermöglicht späteres Ersetzen/Erweitern (z. B. Unit-Tests, Mocking,
 *   unterschiedliche Umgebungen) ohne Code-Duplizierung.
 *
 * Was sie macht:
 * - Baut den DSN zusammen, setzt sinnvolle PDO-Optionen (Fehler als
 *   Exceptions, UTF-8, echtes Prepared-Statement-Verhalten) und gibt die
 *   fertige PDO-Verbindung zurück.
 *
 * Rückgabe:
 * - PDO: eine verbundene PDO-Instanz.
 *
 * Fehlerverhalten:
 * - Bei Verbindungsfehlern wird die Ausführung mit einer beschreibenden
 *   Fehlermeldung beendet (in Produktivsystemen sollte das Logging statt
 *   direkte Ausgabe verwendet werden).
 */
function getPDO(): PDO
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "classicmodels";

    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
        // In einer produktiven Umgebung nicht die rohe Fehlermeldung ausgeben.
        die('DB-Verbindung fehlgeschlagen: ' . htmlspecialchars($e->getMessage())) ;
    }
}
