<?php include 'templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Datei hochladen</h2>
</header>
<nav id="nav-sub">
    <a href="info.php" tabindex="4" class="button"><i class="fa fa-chevron-left"></i> zurück</a>
</nav>
<div class="container-center">
    <div class="info-box">
        <p>Du kannst Bilder im png, jpg, gif Format und Dokumente im pdf Format mit maximal <?php echo UPLOAD_SIZE_MAX_IN_MEGABYTE;?> MB hochladen.</p>
    </div>
    <form method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Datei auswählen</legend>
            <div>
                <label for="info_file_label">Bezeichnung</label>
                <input id="info_file_label" name="info_file_label" tabindex="1" value="<?php echo (isset($_POST['info_file_label']))? $_POST['info_file_label'] : '';?>" required>
            </div>
            <div>
                <label for="file">Datei</label>
                <input id="file" type="file" name="file" tabindex="2">
            </div>
        </fieldset>
        <div class="from-button">
            <button name="upload" class="active" tabindex="3">
                <i class="fa fa-cloud-upload"></i> Datei hochladen
            </button>
        </div>
    </form>
</div>