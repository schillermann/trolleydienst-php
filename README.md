[ [Deutsch](#trolleydienst-planer) ] [ [English](#trolley-service-planner) ]

# Trolleydienst Planer
Plane den Trolleydienst für deine Versammlung kinderleicht.
Du kannst das Trolley Programm auf deinen Server installieren und nach belieben in der Programmiersprache PHP an die Bedürfnisse deiner Versammlung anpassen.

[Trolleydienst Demo](https://trolleydienst-demo.schillermann.de/)

## :cloud: Download
- [Alle Versionen](https://github.com/schillermann/trolleydienst-php/tags)
- [Letzte Verion](https://github.com/schillermann/trolleydienst-php/releases/tag/1.11.0)


## :gem: Funktionen
- Einfache Installation
- Ohne MySQL Datenbank
- Übersichtliche Bedienung
- Einfache Backup Möglichkeit
- Login Schutz vor Hacker Angriffe
- Berichte können abgegeben werden
- E-Mail Versand an alle Teilnehmer über PHP mail, STMP oder Sendinblue
- Mehrere Anwendungen auf einer Domain, durch Unterordner, möglich 
- Kann mit PHP Kenntnissen leicht angepasst werden
- Hochgeladene Dateien sind vor dem Zugriff von außen geschützt
- Teilnehmer können andere Teilnehmer in eine Schicht eintragen
- Mehrere Schichttypen wie z.B. Trolley, Infostand, usw können angelegt werden
- Schichtverlauf, Login Fehlversuche und System Fehlermeldungen bequem einsehbar

## :desktop_computer: Systemanforderungen
Minimum **PHP7** und **Sqlite** muss auf dem Server installiert sein.

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

# Trolley Service Planner
Easily schedule trolley service for your congregation.
You can install the trolley program on your server and adapt it to the needs of your congeregation using the PHP programming language.

[Trolley service demo](https://trolleydienst-demo.schillermann.de/)

## :cloud: Download
- [All versions](https://github.com/schillermann/trolleydienst-php/tags)
- [Latest Version](https://github.com/schillermann/trolleydienst-php/releases/tag/1.11.0)


## :gem: Functions
- Easy installation
- No MySQL database needed
- Simple operation
- Easy backup option
- Login protection against hacker attacks
- Reports can be submitted
- E-mail dispatch to all participants via PHP mail, STMP or Sendinblue
- Several applications on one domain possible, using subfolders
- Can be easily customized with PHP knowledge
- Uploaded files are protected from external access
- Administrators can add other participants to a shift
- Several shift types such as trolley, information stand, etc. can be created
- Shift history, failed login attempts and system error messages can be easily viewed

## :desktop_computer: Server Requirements
Minimum server requirements: **PHP7** and **Sqlite**

## :floppy_disk: Install Software
1. Download the latest trolley service version and unzip the file.
2. Upload the unzipped files to your server using an FTP program of your choice.
3. Next, load the install.php page, where you can enter your user data.
4. After you have clicked on install, the application is set up.

## :wrench: Update Software
1. Make a backup of the database.sqlite and config.php files
2. Upload the latest version to your server and overwrite the old files. You can also delete all files before uploading the latest version, except for config.php and database.sqlite.
3. After all files have been uploaded to your server, load the update.php page to update your database.
4. After a successful update, please delete the update.php file from your server for security reasons.
