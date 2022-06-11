# Trolleydienst Planer
Plane den Trolleydienst für deine Versammlung kinderleicht.
Du kannst das Trolley Programm auf deinen Server installieren und nach belieben in der Programmiersprache PHP an die Bedürfnisse deiner Versammlung anpassen.

## :cloud: Download
- [Alle Versionen](https://github.com/schillermann/trolleydienst-php/tags)
- [Letzte Verion](https://github.com/schillermann/trolleydienst-php/releases/tag/1.6.2)


## :gem: Funktionen
- Einfache Installation
- Ohne MySQL Datenbank
- Übersichtliche Bedienung
- Einfache Backup Möglichkeit
- Login Schutz vor Hacker Angriffe
- Berichte können abgegeben werden
- E-Mail Versand an alle Teilnehmer
- Kann mit PHP Kenntnissen leicht angepasst werden
- Hochgeladene Dateien sind vor dem Zugriff von außen geschützt
- Teilnehmer können andere Teilnehmer in eine Schicht eintragen
- Mehrere Schichttypen wie z.B. Trolley, Infostand, usw können angelegt werden
- Schichtverlauf, Login Fehlversuche und System Fehlermeldungen bequem einsehbar

## :desktop_computer: Systemanforderungen
Minimum PHP7 und Sqlite muss auf dem Server installiert sein.

## :floppy_disk: Software installieren
1. Lade dir die letzte Trolleydienst Version herunter und entpacke die Datei.
2. Die enpackten Dateien lädst du mit einem FTP Programm deiner Wahl auf deinen Server.
3. Als nächstes rufst du die install.php Seite auf, wo du deine Benutzerdaten hinterlegst.
4. Nach dem du auf installieren gedrückt hast ist die Anwendung fertig eingerichtet.

## :wrench: Software aktualisieren
1. Erstelle ein Backup der Dateien database.sqlite und config.php
2. Auf deinen Server lädst du die neuste Version hoch und überschreibst die alten Dateien. Du kannst auch vorher alle Dateien, bis auf die config.php und database.sqlite löschen, bevor du die aktuellste Version hoch lädst.
3. Nachdem alle Dateien auf deinem Server hochgeladen wurden musst du noch die Seite update.php aufrufen. Dadurch wird deine Datenbank auf den neusten Stand gebracht.
4. Nach einem erfolgreichen Update lösche bitte aus Sicherheitsgründen die Datein update.php von deinem Server.