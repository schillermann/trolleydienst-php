<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?php echo __("Info hochladen"); ?></h2>
</header>
<nav id="nav-sub">
    <a href="./info.php" class="button">
        <i class="fa fa-chevron-left"></i> <?php echo __("zurück"); ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?php echo __("Info"); ?></legend>
            <div>
                <label for="info_file_label"><?php echo __("Bezeichnung"); ?></label>
                <input id="info_file_label" name="info_file_label" value="<?php echo $placeholder['info_file_label']; ?>">
            </div>

        </fieldset>
        <div class="from-button">
            <input type="hidden" value="<?php echo $_GET['id_info'];?>">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?php echo __("speichern"); ?>
            </button>
            <button name="delete" class="warning">
                <i class="fa fa-trash-o"></i> <?php echo __("löschen"); ?>
            </button>

        </div>
    </form>
</div>