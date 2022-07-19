<header>
    <h2><?= __('Edit Shift') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./shift.php?id_shift_type=<?= $placeholder['id_shift_type'];?>" class="button">
        <i class="fa fa-chevron-left"></i> <?= __('Back') ?>
    </a>
</nav>
<div class="container-center">

    <?php include '../templates/pagesnippets/note-box.php' ?>

    <form method="post">
        <fieldset>
            <legend><?= __('Shifts') ?></legend>
            <div>
                <label for="route"><?= __('Location') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="route" name="route" required value="<?= $placeholder['route'];?>">
            </div>
            <div>
                <label for="date_from"><?= __('Start Date') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="date_from" type="date" name="date_from" required value="<?= $placeholder['date_from'];?>">
            </div>
            <div>
                <label for="time_from"><?= __('From') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="time_from" type="time" name="time_from" required onchange="calculateShiftTimeTo()" value="<?= $placeholder['time_from'];?>">
            </div>
            <div>
                <label for="number"><?= __('Publishers per Shift') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="number" type="number" name="number" required value="<?= $placeholder['number'];?>" disabled>
            </div>
            <div>
                <label for="hours_per_shift"><?= __('Shift Lenfth in Hours') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="hours_per_shift" type="number" name="hours_per_shift" required value="<?= $placeholder['hours_per_shift'];?>" onchange="calculateShiftTimeTo()" value="<?= $placeholder['hours_per_shift'];?>">
            </div>
            <div>
                <label for="time_to"><?= __('To') ?></label>
                <input id="time_to" type="time" name="time_to" disabled>
            </div>
            <div>
                <label for="color_hex"><?= __('Colour') ?></label>
                <input id="color_hex" type="color" name="color_hex" maxlength="5" required value="<?= $placeholder['color_hex'];?>">
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
        <p><strong><?= __('Updated on') ?>:</strong> <?= $placeholder['updated'];?> - <strong><?= __('Created on') ?>:</strong> <?= $placeholder['created'];?></p>
    </div>
</div>
<script type="text/javascript" src="js/calculate_shift_datetime_to.js"></script>
<script>
    calculateShiftTimeTo();
</script>