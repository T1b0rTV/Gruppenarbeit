# Dokumentation — Gruppenaufgabe (Classic Models)

Dieses Dokument listet alle vorhandenen Funktionen, Endpunkte, Formulare, Eingabe-/Ausgabeformen, Fehlerfälle und Testschritte für die Implementierung im Ordner `Donnerstag/Aufgaben/Gruppenaufgabe`.

## Kurzer Überblick
- Zweck: Kleine Demo-Webseite mit Such- und Anlegefunktion für die Beispiel-DB `classicmodels`.
- Wichtige Dateien:
  - `db_connect.php` — DB-Verbindungs-Helfer (verwendet `Mittwoch/db_config.php` falls vorhanden)
  - `index.php` — Landingpage
  - `search.php` — Suche (zeigt Produkte / filtert nach Bezeichner)
  - `create.php` — Login + Formular zum Anlegen neuer Produkte
  - `style.css` — Styling (modernisiert)
  - `README.md` — Kurzanleitung
  - `DOCUMENTATION.md` — dieses Dokument

## Zusammenfassung der Funktionalität (Kurz)
- Suche: GET-Parameter `q` (Bezeichner / productName). Zeigt in einer HTML-Tabelle: productCode, productName, productLine, productScale, buyPrice. Maximale Rückgabe: 200 Zeilen.
- Anlegen: Session-Login (harte Credentials), Formular mit Feldern `productCode`, `productName`, `productLine`, `productScale`, `buyPrice`. Serverseitige Prüfung: Code/Name erforderlich, Preis numerisch. Insert per Prepared Statement.

---

## Detaillierte Funktionsliste und Verhalten

### 1) `getPDO()` (Definitionen)
- Speicherorte:
  - Primär: `Mittwoch/db_config.php` (wenn vorhanden, wird diese Datei eingebunden)
  - Fallback: `Donnerstag/Aufgaben/Gruppenaufgabe/db_connect.php` definiert `getPDO()` falls die zentrale Datei nicht gefunden wird.
- Signatur: `function getPDO(): PDO`
- Zweck: Liefert eine konfigurierte `PDO`-Instanz, verbunden zur Datenbank `classicmodels`.
- Verwendete Optionen:
  - `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`
  - `PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC`
  - `PDO::ATTR_EMULATE_PREPARES => false`
- Fehlerverhalten: Bei Verbindungsfehler wird die Ausführung mit `die()` abgebrochen und eine (URL-escaped) Fehlermeldung ausgegeben. (Hinweis: In Produktivsystemen Logging statt direkter Ausgabe empfohlen.)

### 2) `search.php` (Suchseite)
- Eingang:
  - Optionaler GET-Parameter `q` (string) — verwendet für LIKE-Suche auf `productName`.
- Verhalten/SQL:
  - Wenn `q` gesetzt: Prepared Statement mit `WHERE productName LIKE :q` und `:q = "%<q>%"`.
  - Wenn nicht gesetzt: alle Produkte (SELECT ohne WHERE).
  - Beide Varianten enthalten `ORDER BY productName LIMIT 200`.
  - Felder: `productCode, productName, productLine, productScale, buyPrice`.
- Ausgabe:
  - HTML-Seite mit Formular zur Suche und einer Ergebnis-Tabelle.
  - Nummer der Treffer wird angezeigt (`count($rows)`).
- Fehler/Sicherheit:
  - Prepared Statements verhindern SQL-Injection.
  - Eingabe wird mit `trim()` gesäubert; Ausgabe mit `htmlentities()` escaped.
  - Limit 200 verhindert sehr große Abfragen.

### 3) `create.php` (Login + Anlegen)
- Session-Handling: `session_start()`.
- Harte Credentials (für die Übung):
  - `USERNAME = 'admin'`
  - `PASSWORD = 'secret'`
- Login-Flow:
  - POST mit `action=login`, Felder `username` und `password`.
  - Bei Erfolg: `$_SESSION['user'] = USERNAME`.
  - Bei Fehler: `$login_error` wird gesetzt und angezeigt.
- Logout: GET-Parameter `?logout=1` zerstört Session und redirectet zurück zu `create.php`.
- Anlegen-Flow:
  - POST mit `action=create` (nur verfügbar wenn eingeloggt via Session).
  - Erwartete Felder: `productCode`, `productName`, `productLine`, `productScale`, `buyPrice`.
  - Validierung:
    - `productCode` und `productName` müssen nicht-leer sein.
    - `buyPrice` muss numerisch sein (`is_numeric`).
  - Insert-Statement (Prepared):
    INSERT INTO products (productCode, productName, productLine, productScale, buyPrice) VALUES (:code,:name,:line,:scale,:price)
  - Auf Erfolg: `$success` Meldung, bei DB-Fehlern wird die Fehlermeldung in `$errors[]` aufgenommen.
- Fehler/Sicherheit:
  - Prepared Statements verhindern SQL-Injection.
  - Keine CSRF-Token vorhanden (Empfehlung: ergänzen).
  - Harte Credentials: unsicher, nur Demo. In Produktivsystemen DB-User-Tabelle + gehashte Passwörter.

### 4) `index.php`
- Einfacher Link-Index zu den drei Seiten.

### 5) `style.css`
- Modernisiertes Styling mit:
  - Farbverlauf-Header, weiße Card-Oberflächen für `main`, abgerundete Buttons,
  - Form-Input-Fokus-Styling, Tabellen mit Hover-Farbe,
  - Responsive Breakpoint bei 600px: Tabelle stellt sich in Block-Layout um.

---

## Datenformen (Inputs / Outputs)
- Suche (`search.php`):
  - Input: GET param `q` (optional)
  - Output: HTML-Tabelle mit Spalten: productCode (string), productName (string), productLine (string), productScale (string), buyPrice (decimal)
- Anlegen (`create.php`):
  - Login: POST `username`, `password` (strings)
  - Create: POST `productCode` (string), `productName` (string), `productLine` (string), `productScale` (string), `buyPrice` (numeric/decimal)
  - Output: Erfolg- oder Fehler-Prompts im HTML

## Fehlerfälle und Edge-Cases
- DB-Verbindungsfehler: `getPDO()` beendet das Script mit einer Fehlermeldung.
- Doppelte `productCode`: DB-Constraint kann INSERT mit PDOException verhindern; aktuell wird Fehlertext angezeigt.
- Nicht-numerischer Preis: Validierung verhindert Insert und zeigt Fehler.
- Große Ergebnissets: Begrenzung auf 200 Zeilen; Pagination nicht implementiert.
- CSRF: nicht geschützt.

## Test- und Prüfhinweise
1. DB bereitstellen: Importiere `mysqlsampledatabase.sql` in deine MySQL-Instanz (phpMyAdmin oder CLI). Beispiel (PowerShell / Windows):

```powershell
# Beispiel: importiere das SQL in die DB classicmodels (XAMPP, root, kein Passwort)
mysql -u root classicmodels < "C:\xampp\htdocs\LF10a\mysqlsampledatabase.sql"
```

2. Starte XAMPP (Apache + MySQL).
3. Öffne im Browser:
   - Landing: `http://localhost/LF10a/Donnerstag/Aufgaben/Gruppenaufgabe/index.php`
   - Suche: `http://localhost/LF10a/Donnerstag/Aufgaben/Gruppenaufgabe/search.php`
   - Anlegen: `http://localhost/LF10a/Donnerstag/Aufgaben/Gruppenaufgabe/create.php`
4. Suche testen:
   - Ohne Parameter: zeigt bis zu 200 Produkte.
   - Mit Parameter: `?q=car` oder `?q=Corvette`.
5. Anlegen testen:
   - Anmelden mit Benutzer `admin` und Passwort `secret`.
   - Formular ausfüllen (Achte auf einzigartigen `productCode`).

## Sicherheitsempfehlungen (priorisiert)
1. Ersetze harte Login-Credentials durch eine Benutzer-Tabelle mit gehashten Passwörtern (password_hash / password_verify).
2. CSRF-Schutz: Token für das Anlegen-Formular und Login-Formular.
3. Fehler-Handling: DB-Fehlermeldungen nicht direkt an Benutzer ausgeben; stattdessen Logging und freundliche Meldungen.
4. Input-Limits: Maximale Längen für Strings serverseitig prüfen.
5. Transaktion: Wenn mehrere DB-Operationen stattfinden, in einer Transaction ausführen.

## Vorschläge für Verbesserungen / Erweiterungen
- Pagination und Such-Highlighting.
- Sortierbare Spalten und Filter (z. B. productLine, Preisbereich).
- Unit/Integration Tests (PHPUnit) für DB-Funktionen (Mock-DB oder Test-DB).
- REST-API-Endpoints (JSON) zusätzlich zu den HTML-Seiten.
- Rollen/Perms: z. B. nur Admins dürfen anlegen.

## Mapping zur Aufgabenstellung
- Einrichtung der Datenbankverbindung: Implementiert (getPDO).
- Erstellung der Suchfunktion: Implementiert (`search.php`) mit Filtermöglichkeit.
- Implementierung der Anlegen-Funktion: Implementiert (`create.php`) mit Login.
- Gestaltung der Webseite: Implementiert (`style.css` modernisiert), responsive Basis.

---

Wenn du möchtest, kann ich jetzt eine der empfohlenen Verbesserungen direkt implementieren (z. B. CSRF-Schutz, Benutzer-Tabelle mit gehashtem Passwort, Pagination oder eine JSON-API). Nenne bitte die gewünschte Aufgabe und ich setze sie um.
