<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?= __('Upload File') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./info.php" class="button"><i class="fa fa-chevron-left"></i> <?= __('Back') ?></a>
</nav>
<div class="container-center">
    <div class="info-box">
        <p>
            <?= __('You can upload images in PNG, JPG and GIF format, and documents in PDF format.') ?>
            <?= __('Maximum file size', [ UPLOAD_SIZE_MAX_IN_MEGABYTE ]) ?>
        </p>
    </div>
    <form method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><?= __('Select a file') ?></legend>
            <div>
                <label for="info_file_label"><?= __('Label') ?></label>
                <input id="info_file_label" name="info_file_label" value="<?= (isset($_POST['info_file_label']))? $_POST['info_file_label'] : '';?>" required>
            </div>
            <div>
                <label for="file"><?= __('File') ?></label>
                <input id="file" type="file" name="file">
            </div>
        </fieldset>
        <div class="from-button">
            <button name="upload" class="active">
                <i class="fa fa-cloud-upload"></i> <?= __('Upload File') ?>
            </button>
        </div>
    </form>
</div>