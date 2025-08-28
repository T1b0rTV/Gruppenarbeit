<?php
// Reuse the project's central DB config if available, otherwise fall back to a local PDO builder.
// The central file is at ../../Mittwoch/db_config.php relative to this folder in the workspace.
if (file_exists(__DIR__ . '/../../Mittwoch/db_config.php')) {
    require_once __DIR__ . '/../../Mittwoch/db_config.php';
} else {
    // Minimal fallback: create a getPDO() compatible function.
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
            die('DB-Verbindung fehlgeschlagen: ' . htmlspecialchars($e->getMessage()));
        }
    }
}
