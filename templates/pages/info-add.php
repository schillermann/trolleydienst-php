<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?php echo __("Datei hochladen"); ?></h2>
</header>
<nav id="nav-sub">
    <a href="./info.php" class="button"><i class="fa fa-chevron-left"></i> <?php echo __("zurück"); ?></a>
</nav>
<div class="container-center">
    <div class="info-box">
        <p><?php 
        $upload_size_max = UPLOAD_SIZE_MAX_IN_MEGABYTE;
        echo __("Du kannst Bilder im png, jpg und gif Format und Dokumente im pdf Format hochladen.") . "<br>(" . __("Maximale Dateigröße") . " " . UPLOAD_SIZE_MAX_IN_MEGABYTE . "MB)"; ?></p>
    </div>
    <form method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><?php echo __("Datei auswählen"); ?></legend>
            <div>
                <label for="info_file_label"><?php echo __("Bezeichnung"); ?></label>
                <input id="info_file_label" name="info_file_label" value="<?php echo (isset($_POST['info_file_label']))? $_POST['info_file_label'] : '';?>" required>
            </div>
            <div>
                <label for="file"><?php echo __("Datei"); ?></label>
                <input id="file" type="file" name="file">
            </div>
        </fieldset>
        <div class="from-button">
            <button name="upload" class="active">
                <i class="fa fa-cloud-upload"></i> <?php echo __("Datei hochladen"); ?>
            </button>
        </div>
    </form>
</div>