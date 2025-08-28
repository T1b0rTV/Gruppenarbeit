# Gruppenaufgabe - Classic Models

Diese Implementierung enthält drei Seiten für die Gruppenaufgabe:

- `index.php` - Landingpage mit Links
- `search.php` - Suchfunktion: zeigt alle Produkte oder filtert nach Bezeichner (productName)
- `create.php` - Anlegen-Funktion für neue Produkte (einfache Session-Login, Benutzer: admin / secret)
- `db_connect.php` - Wiederverwendet `Mittwoch/db_config.php` falls vorhanden oder nutzt Fallback
- `style.css` - kleines Styling

Hinweis:
- Die Anwendung erwartet die Datenbank `classicmodels` und die Tabelle `products` (Standard aus dem sample schema).
- Zum Testen: platziere die Dateien im lokalen XAMPP htdocs und öffne z.B. http://localhost/LF10a/Donnerstag/Aufgaben/Gruppenaufgabe/index.php
