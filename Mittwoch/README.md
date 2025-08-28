# Produkt-Suche (Mittwoch)

Dieses Verzeichnis enthält ein kleines PHP-Demoprojekt, das zeigt, wie man
eine MySQL-Datenbank (classicmodels) per PDO abfragt, eine einfache
Suchoberfläche bereitstellt und Ergebnisse sicher als HTML-Tabelle ausgibt.

Inhalte
- `db_config.php` - zentrale Funktion `getPDO()` für die DB-Verbindung
- `datenbankverbindung.php` - Hauptseite mit Suchformular und Ergebnis-Tabelle
- `style.css` - modernes Styling für die Seite

Ziel
- Lern- und Demozweck: sichere DB-Verbindung, Prepared Statements, XSS-Schutz,
  einfache UI.

Voraussetzungen
- PHP 7.4+ (empfohlen) mit PDO MySQL (ext-pdo, ext-pdo_mysql)
- MySQL mit Datenbank `classicmodels` (die Sample-DB ist weit verbreitet)
- XAMPP oder vergleichbare lokale Umgebung (Apache + MySQL)

Kurzanleitung (lokal)
1. XAMPP starten (Apache + MySQL).
2. Stelle sicher, dass die DB `classicmodels` existiert. Falls nicht, importiere die Sample-DB.
3. Öffne im Browser: `http://localhost/LF10a/Mittwoch/datenbankverbindung.php`

CLI-Checks
Wenn die PHP-CLI in PATH ist, kannst du Syntaxprüfungen ausführen:
```powershell
php -l "c:\xampp\htdocs\LF10a\Mittwoch\db_config.php"
php -l "c:\xampp\htdocs\LF10a\Mittwoch\datenbankverbindung.php"
```

Funktionen (Erklärung)

- getPDO() — `db_config.php`
  - Zweck: Kapselt die Erstellung einer PDO-Instanz.
  - Warum: Verhindert Duplizierung der Verbindungslogik und erleichtert
    Tests und Austausch (z. B. für Mocking).
  - Verhalten: Gibt eine konfigurierte PDO-Instanz zurück oder beendet das
    Skript bei Verbindungsfehler (in Produktivcode sollte stattdessen geloggt
    und ein Nutzerfreundliches Error-UI gezeigt werden).

- e(string $s): string — `datenbankverbindung.php`
  - Zweck: Einfacher HTML-Escaper für die Ausgabe.
  - Warum: Zentralisiertes Escaping verhindert XSS.

Suchverhalten
- Einfache Suche: gib einen Begriff ein — das Skript sucht per SQL LIKE
  (`%term%`) im Feld `productName`.
- Mehrfachbegriffe:
  - `and` (case-insensitive): Verknüpfung als AND (alle Begriffe müssen vorkommen)
    - Beispiel: `harley and renault`
  - `or` : Verknüpfung als OR
    - Beispiel: `harley or renault`
  - Standard (kein and/or): Leerzeichen oder Komma trennen Begriffe -> OR-Verknüpfung
    - Beispiel: `harley renault` oder `harley,renault`

Sicherheit & Hinweise
- Prepared Statements werden benutzt — verhindert SQL-Injection.
- HTML-Ausgabe wird mit `htmlspecialchars()` escaped — verhindert XSS.
- Performance: Viele Wildcard-OR-Clauses können langsam sein. Für
  Produktionssysteme: Indexe prüfen, LIMIT/Pagination einführen, oder
  Fulltext-Suche verwenden.

Erweiterungen, die bereits umgesetzt wurden

 - AJAX-Live-Suche: `script.js` führt debounced Fetch-Requests zum Server-Endpunkt (`?ajax=1`) aus und rendert die Ergebnisse ohne Seiten-Reload.
 - AJAX-Live-Suche: `script.js` führt debounced Fetch-Requests per POST zum Server-Endpunkt (`ajax=1`) aus und rendert die Ergebnisse ohne Seiten-Reload. Formulare werden jetzt per POST gesendet (sicherer als GET).
 - Pagination: Serverseitig mit `LIMIT`/`OFFSET` und clientseitigen Paginierungsbuttons (Standard `per_page` = 10). Die Paginierung wird in `script.js` gerendert.
 - Pagination UI: Prev/Next und numerische Buttons; aktive Seite wird hervorgehoben.
 - Treffer-Highlighting: Der erste Suchbegriff wird im Ergebnis hervorgehoben (visuelles Markup).
 - CTA-Landing: Kurze Call-to-Action Sektion oben (informativ, kein aktiver Demo-Button).

Hinweis: Das ursprüngliche Hero-SVG wurde entfernt auf Wunsch, stattdessen wurde die Seite mit einer CTA-Section und besseren Typografie veredelt.

Weitere empfohlene Schritte

- Konfiguration: Umstellung auf `.env` + phpdotenv statt harter DB-Daten.
- Tests: Unit-Tests für Datenzugriff (z. B. PHPUnit mit Test-DB oder Mocks).

Fehlerbehebung & Tests

- Fehlermeldung "php is not recognized": PHP-CLI ist nicht im PATH. Entweder XAMPP's PHP zu PATH hinzufügen oder die PHP-Binaries direkt mit dem vollen Pfad aufrufen, z. B.:

```powershell
C:\xampp\php\php.exe -l "c:\xampp\htdocs\LF10a\Mittwoch\db_config.php"
C:\xampp\php\php.exe -l "c:\xampp\htdocs\LF10a\Mittwoch\datenbankverbindung.php"
```

- Testen der Live-Suche
  1. Seite öffnen: `http://localhost/LF10a/Mittwoch/datenbankverbindung.php`
  2. Tippe in das Suchfeld — nach ~350ms (Debounce) wird eine AJAX-Anfrage an `?ajax=1&q=...` gesendet.
  3. Ergebnisse und Paginierung erscheinen dynamisch.

 - Test mit curl (POST JSON-Endpoint):

```powershell
curl -X POST -F "ajax=1" -F "q=renault" -F "page=1" -F "per_page=10" http://localhost/LF10a/Mittwoch/datenbankverbindung.php
```

Server-Endpoint

- `datenbankverbindung.php?ajax=1&q=...&page=1&per_page=10` liefert JSON:

```json
{
  "total": 123,
  "page": 1,
  "per_page": 10,
  "results": [ {"productCode":"...","productName":"...", ... }, ... ]
}
```

Fehlerbehebung
- Fehlermeldung "php is not recognized": PHP-CLI ist nicht im PATH. Entweder
  XAMPP's PHP zu PATH hinzufügen oder die PHP-Binaries direkt mit dem vollen
  Pfad aufrufen, z. B. `C:\xampp\php\php.exe -l <file>`.

Kontakt / Weiteres
- Wenn du möchtest, implementiere ich Pagination oder eine AJAX-Suche.
  Sag mir, welche Erweiterung du zuerst willst und ich mache das.
