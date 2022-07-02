<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?= __('Edit File') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./info.php" class="button">
        <i class="fa fa-chevron-left"></i> <?= __('Back') ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?= __('Info') ?></legend>
            <div>
                <label for="info_file_label"><?= __('Label') ?></label>
                <input id="info_file_label" name="info_file_label" value="<?= $placeholder['info_file_label'] ?>">
            </div>

        </fieldset>
        <div class="from-button">
            <input type="hidden" value="<?= $_GET['id_info'];?>">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?= __('Save') ?>
            </button>
            <button name="delete" class="warning">
                <i class="fa fa-trash-o"></i> <?= __('Delete') ?>
            </button>

        </div>
    </form>
</div>