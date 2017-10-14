<?php include 'templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Info hochladen</h2>
</header>
<nav id="nav-sub">
    <a href="info.php" tabindex="4" class="button">
        <i class="fa fa-chevron-left"></i> zurück
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Info</legend>
            <div>
                <label for="info_file_label">Bezeichnung</label>
                <input id="info_file_label" name="info_file_label" tabindex="1" value="<?php echo $placeholder['info_file_label']; ?>">
            </div>

        </fieldset>
        <div class="from-button">
            <input type="hidden" value="<?php echo $_GET['id_info'];?>">
            <button name="save" class="active" tabindex="2">
                <i class="fa fa-floppy-o"></i> speichern
            </button>
            <button name="delete" class="warning" tabindex="3">
                <i class="fa fa-trash-o"></i> löschen
            </button>

        </div>
    </form>
</div>