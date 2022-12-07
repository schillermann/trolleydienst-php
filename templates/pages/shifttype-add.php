<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?= __('New Shift Type') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./shift-type" class="button">
        <i class="fa fa-chevron-left"></i> <?= __('Back') ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?= __('Shift Type') ?></legend>
            <div>
                <label for="name"><?= __('Name') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="name" name="name" required value="<?= (isset($_POST['name']))? $_POST['name'] : '';?>">
            </div>
            <div>
                <label for="user_per_shift_max"><?= __('Max. Publishers per Shift') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="user_per_shift_max" type="number" name="user_per_shift_max" required value="<?= (isset($_POST['user_per_shift_max']))? $_POST['user_per_shift_max'] : 2;?>">
            </div>
            <div>
                <label for="shift_type_info"><?= __('Info') ?></label>
                <textarea id="shift_type_info" name="shift_type_info" class="note"><?= (isset($_POST['shift_type_info']))? $_POST['shift_type_info'] : '';?></textarea>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?= __('Save') ?>
            </button>
        </div>
    </form>
</div>