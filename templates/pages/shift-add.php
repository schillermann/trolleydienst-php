<?php if (isset($placeholder['message'])) : ?>
    <div id="note-box" class="fade-in">
		<?php if (isset($placeholder['message']['success'])) : ?>
            <p class="success">
                <?= __('The following shifts were created:') ?>
            <ul>
				<?php foreach ($placeholder['message']['success'] as $shiftday): ?>
                    <li><?= $shiftday ?></li>
				<?php endforeach;?>
            </ul>
            </p>
		<?php elseif(isset($placeholder['message']['error'])): ?>
            <p class="error">
            <?= __('The following shifts could not be created:') ?>
            <ul>
				<?php foreach ($placeholder['message']['error'] as $shiftday): ?>
                    <li><?= $shiftday ?></li>
				<?php endforeach;?>
            </ul>
            </p>
		<?php endif ?>
        <button type="button" onclick="closeNoteBox()">
            <i class="fa fa-times"></i> <?= __('Close') ?>
        </button>
    </div>
<?php endif ?>
<header>
    <h2><?= __('New Shifts') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./shift.php?id_shift_type=<?= $placeholder['id_shift_type']?>" class="button">
        <i class="fa fa-chevron-left"></i> <?= __('Back') ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?= __('Shifts') ?></legend>
            <div>
                <label for="route"><?= __('Shifts') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="route" name="route" required placeholder="<?= __('What is the name of this location?') ?>" value="<?= (isset($_POST['route']))? $_POST['route'] : '';?>">
            </div>
            <div>
                <label for="date_from"><?= __('Start Date') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="date_from" type="date" name="date_from" required value="<?= (isset($_POST['date_from']))? $_POST['date_from'] : '';?>">
            </div>
            <div>
                <label for="time_from"><?= __('From') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="time_from" type="time" name="time_from" required onchange="calculateShiftTimeTo()" value="<?= (isset($_POST['time_from']))? $_POST['time_from'] : '';?>">
            </div>
            <div>
                <label for="number"><?= __('Publishers per Shift') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="number" type="number" name="number" required onchange="calculateShiftTimeTo()" value="<?= (isset($_POST['number']))? (int)$_POST['number'] : 2;?>">
            </div>
            <div>
                <label for="hours_per_shift"><?= __('Shift Lenfth in Hours') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="hours_per_shift" type="number" name="hours_per_shift" required value="<?= (isset($_POST['hours_per_shift']))? (int)$_POST['hours_per_shift'] : 2;?>" onchange="calculateShiftTimeTo()">
            </div>
            <div>
                <label for="time_to"><?= __('To') ?></label>
                <input id="time_to" type="time" name="time_to" disabled>
            </div>

            <div>
                <label for="shiftday_series_until"><?= __('End Date') ?></label>
                <input id="shiftday_series_until" type="date" name="shiftday_series_until" value="<?= (isset($_POST['shiftday_series_until']))? $_POST['shiftday_series_until'] : '';?>">
            </div>
            <div>
                <label for="color_hex"><?= __('Colour') ?></label>
                <input id="color_hex" type="color" name="color_hex" value="#d5c8e4" maxlength="7" required>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?= __('Save') ?>
            </button>
        </div>
    </form>
</div>
<script type="text/javascript" src="js/calculate_shift_datetime_to.js"></script>