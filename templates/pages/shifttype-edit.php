<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Schichttyp bearbeiten</h2>
</header>
<nav>
    <a href="shifttype.php" class="button">
        <i class="fa fa-chevron-left"></i> zurück
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Schichttyp</legend>
            <div>
                <label for="name">Name <small>(Pflichtfeld)</small></label>
                <input id="name" name="name" required value="<?php echo $placeholder['shift_type']['name'];?>">
            </div>
            <div>
                <label for="user_per_shift_max">Teilnehmer pro Schicht maximal <small>(Pflichtfeld)</small></label>
                <input id="user_per_shift_max" type="number" name="user_per_shift_max" required value="<?php echo $placeholder['shift_type']['user_per_shift_max'];?>">
            </div>
            <div>
                <label for="shift_type_info">Info</label>
                <textarea id="shift_type_info" name="shift_type_info" class="note"><?php echo $placeholder['shift_type']['info'];?></textarea>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> speichern
            </button>
            <button name="delete" class="warning">
                <i class="fa fa-trash-o"></i> löschen
            </button>
        </div>
    </form>
    <div id="footnote">
        <p><strong>Geändert am:</strong> <?php echo $placeholder['shift_type']['updated'];?> - <strong>Erstellt am:</strong> <?php echo $placeholder['shift_type']['created'];?></p>
    </div>
</div>