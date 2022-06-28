<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Update</h2>
    <a href="./" class="button"><i class="fa fa-chevron-left"></i> zurück</a>
</header>
<div class="container-center">
    
    <?php if($placeholder['is_up_to_date']) : ?>
        <div class="info-box">
            <p>
                <strong style="color:red">ACHTUNG:</strong> Aus Sicherheitsgründen lösche die Datei update.php auf dem Server.
            </p>
        </div>
        <p>Die Datenbank ist auf dem aktuellsten Stand.</p>
        <p>
            Sobald eine neue Version von Trolleydienst PHP auf <a href="https://trolleydienst.de">trolleydienst.de</a> zur Verfügung,
            steht kannst du sie herunterladen und auf deinen Server hochladen.
        </p>
        <p>
           Beim Hochladen musst du die vorhandenen Dateien überschreiben.
           Du kannst auch die alte Version löschen, bevor du die neue Version hoch lädst.
           Es dürfen dabei die Dateien config.php und database.sqlite <strong style="color:red">NICHT GELÖSCHT</strong> werden.
       </p>
       <p>
            Als nächstes musst du das Update starten um die Datenbank auf den neusten Stand zu bringen.
        </p>
    <?php else: ?>
        <div class="info-box">
            <p>Die Datenbank muss aktuallisiert werden.</p>
        </div>
        <p>
            <strong style="color:red">Bitte starte das Update jetzt.</strong>
        </p>
        <p>
            <form method="post">
               <div class="from-button">
                   <button name="update" class="active">
                       <i class="fa fa-floppy-o"></i> Update starten
                   </button>
               </div>
           </form>
       </p>
    <?php endif; ?>
</div>