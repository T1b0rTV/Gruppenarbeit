# Gruppenaufgabe — Classic Models

Dies ist eine kleine Demo-Webanwendung für die Gruppenaufgabe: sie zeigt, wie man eine einfache Suchfunktion und eine Anlegefunktion für die Beispiel-Datenbank `classicmodels` mit PHP und PDO implementiert.

## Inhalt dieses Ordners
- `index.php` — Landingpage mit Navigation zu den Funktionen
- `search.php` — Suchseite: zeigt alle Produkte oder filtert nach Bezeichner (`productName`)
- `create.php` — Login-Seite und Formular zum Anlegen neuer Produkte (Session-basiert, Demo-Credentials)
- `db_connect.php` — DB-Helfer: verwendet `Mittwoch/db_config.php` falls vorhanden, sonst Fallback `getPDO()`
- `style.css` — CSS für Layout und Design
- `README.md` — diese Datei (Setup, Nutzung, Hinweise)
- `DOCUMENTATION.md` — ausführliche Funktions- und Entwicklerdoku

## Voraussetzungen
- Lokaler Webserver mit PHP (z. B. XAMPP/Apache)
- MySQL / MariaDB mit der Beispiel-Datenbank `classicmodels` (das SQL-Skript `mysqlsampledatabase.sql` liegt im Projekt)

## Installation / Setup
1. Starte XAMPP (Apache + MySQL) oder einen anderen lokalen Server.
2. Importiere die Beispiel-DB (phpMyAdmin oder CLI). Beispiel mit MySQL-CLI (Windows PowerShell):

```powershell
mysql -u root classicmodels < "C:\xampp\htdocs\LF10a\mysqlsampledatabase.sql"
```

3. Lege sicher, dass der Ordner `Donnerstag/Aufgaben/Gruppenaufgabe` im DocumentRoot deines Webservers erreichbar ist (bei XAMPP: `htdocs/LF10a/...`).
4. Öffne den Browser:
	- Landing: `http://localhost/LF10a/Donnerstag/Aufgaben/Gruppenaufgabe/index.php`
	- Suche: `http://localhost/LF10a/Donnerstag/Aufgaben/Gruppenaufgabe/search.php`
	- Anlegen: `http://localhost/LF10a/Donnerstag/Aufgaben/Gruppenaufgabe/create.php`

## Nutzung
- Suche: Gib im Suchfeld einen Teil des Produktnamens ein (z. B. `Corvette`) und klicke auf `Suchen`. Ohne Eingabe werden bis zu 200 Produkte angezeigt.
- Anlegen: Klicke auf `Anlegen`, melde dich an (Demo-Zugang) und fülle das Formular aus.

Demo-Anmeldedaten (nur für Übungszwecke):
- Benutzer: `admin`
- Passwort: `secret`

Wichtig: Diese Zugangsdaten sind bewusst einfach gehalten und nur für die Übung gedacht. Verwende sie NICHT in Produktivumgebungen.

## Sicherheitshinweise
- Die Anwendung verwendet Prepared Statements (PDO) und `htmlentities()` zur Ausgabe, um grundlegende SQL-Injection- und XSS-Risiken zu reduzieren.
- Es gibt jedoch bekannte Lücken, die bei einer produktiven Nutzung geschlossen werden müssen:
  - Harte Credentials: Ersetze durch eine Benutzerverwaltung mit gehashten Passwörtern (password_hash / password_verify).
  - CSRF-Schutz: Token für Login- und Create-Formulare ergänzen.
  - Fehler-Handling: Aktuell werden DB-Fehlermeldungen an den Benutzer ausgegeben. Besser: internes Logging und generische Fehlermeldungen.

## Tests / Prüfschritte
1. Suche ohne Parameter: sollte (bis zu) 200 Zeilen zurückgeben.
2. Suche mit `?q=<term>`: zeigt nur Treffer mit `productName` LIKE `%<term>%`.
3. Anlegen:
	- Anmelden mit `admin` / `secret`.
	- Formular ausfüllen; `productCode` sollte eindeutig sein (unique key in DB), `buyPrice` numerisch.
	- Bei Erfolg erscheint eine Bestätigung; bei Fehlern werden diese angezeigt.

## Entwicklerhinweise
- DB-Verbindung: `db_connect.php` versucht zuerst, die Projekt-weite Konfiguration `Mittwoch/db_config.php` zu nutzen — so bleiben Einstellungen DRY.
- Prepared Statements und PDO-Optionen sind gesetzt (`ERRMODE_EXCEPTION`, `EMULATE_PREPARES=false`).

## Weiteres / Verbesserungsmöglichkeiten
- CSRF-Schutz, Pagination, Sortierung, REST-API-Endpoints, Userverwaltung mit Rollen.

Wenn du möchtest, setze ich eine dieser Verbesserungen direkt um — nenne kurz, welche (z. B. CSRF-Schutz oder gehashte Logins) und ich implementiere sie.
