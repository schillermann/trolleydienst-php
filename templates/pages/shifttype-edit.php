<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?= __('Edit Shift Type') ?></h2>
</header>
<nav>
    <a href="./shifttype.php" class="button">
        <i class="fa fa-chevron-left"></i> <?= __('Back') ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?= __('Shift Type') ?></legend>
            <div>
                <label for="name"><?= __('Name') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="name" name="name" required value="<?= $placeholder['shift_type']['name'];?>">
            </div>
            <div>
                <label for="user_per_shift_max"><?= __('Max. Publishers per Shift') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="user_per_shift_max" type="number" name="user_per_shift_max" required value="<?= $placeholder['shift_type']['user_per_shift_max'];?>">
            </div>
            <div>
                <label for="shift_type_info"><?= __('Info') ?></label>
                <textarea id="shift_type_info" name="shift_type_info" class="note"><?= $placeholder['shift_type']['info'];?></textarea>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?= __('Save') ?>
            </button>
            <button name="delete" class="warning">
                <i class="fa fa-trash-o"></i> <?= __('Delete') ?>
            </button>
        </div>
    </form>
    <div id="footnote">
        <p><strong><?= __('Updated on') ?>:</strong> <?= $placeholder['shift_type']['updated'];?> - <strong><?= __('Created on') ?>:</strong> <?= $placeholder['shift_type']['created'];?></p>
    </div>
</div>