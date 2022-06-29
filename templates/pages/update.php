<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?php echo __("Update"); ?></h2>
    <a href="./" class="button"><i class="fa fa-chevron-left"></i> <?php echo __("zurück"); ?></a>
</header>
<div class="container-center">
    
    <?php if($placeholder['is_up_to_date']) : ?>
        <div class="info-box">
            <p>
                <strong style="color:red"><?php echo __("ACHTUNG"); ?>:</strong> <?php echo __("Aus Sicherheitsgründen lösche die Datei update.php auf dem Server."); ?>
            </p>
        </div>
        <p><?php echo __("Die Datenbank ist auf dem aktuellsten Stand."); ?></p>
        <p>
        <?php echo __("Sobald eine neue Version von Trolleydienst PHP auf"); ?> <a href="https://trolleydienst.de">trolleydienst.de</a> <?php echo __("zur Verfügung, steht kannst du sie herunterladen und auf deinen Server hochladen."); ?>
        </p>
        <p>
        <?php echo __("Beim Hochladen musst du die vorhandenen Dateien überschreiben."); ?>
        <?php echo __("Du kannst auch die alte Version löschen, bevor du die neue Version hoch lädst."); ?>
        <?php echo __("Es dürfen dabei die Dateien config.php und database.sqlite"); ?> <strong style="color:red"><?php echo __("NICHT GELÖSCHT"); ?></strong> <?php echo __("werden."); ?>
       </p>
       <p>
       <?php echo __("Als nächstes musst du das Update starten um die Datenbank auf den neusten Stand zu bringen."); ?>
        </p>
    <?php else: ?>
        <div class="info-box">
            <p><?php echo __("Die Datenbank muss aktuallisiert werden."); ?></p>
        </div>
        <p>
            <strong style="color:red"><?php echo __("Bitte starte das Update jetzt."); ?></strong>
        </p>
        <p>
            <form method="post">
               <div class="from-button">
                   <button name="update" class="active">
                       <i class="fa fa-floppy-o"></i> <?php echo __("Update starten"); ?>
                   </button>
               </div>
           </form>
       </p>
    <?php endif; ?>
</div>