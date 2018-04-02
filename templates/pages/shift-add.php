<?php if (isset($placeholder['message'])) : ?>
    <div id="note-box" class="fade-in">
		<?php if (isset($placeholder['message']['success'])) : ?>
            <p class="success">
                Folgende Schichten wurden angelegt:
            <ul>
				<?php foreach ($placeholder['message']['success'] as $shiftday): ?>
                    <li><?php echo $shiftday; ?></li>
				<?php endforeach;?>
            </ul>
            </p>
		<?php elseif(isset($placeholder['message']['error'])): ?>
            <p class="error">
                Folgende Schichten konnten nicht angelegt werden:
            <ul>
				<?php foreach ($placeholder['message']['error'] as $shiftday): ?>
                    <li><?php echo $shiftday; ?></li>
				<?php endforeach;?>
            </ul>
            </p>
		<?php endif; ?>
        <button type="button" onclick="closeNoteBox()">
            <i class="fa fa-times"></i> schliessen
        </button>
    </div>
<?php endif; ?>
<header>
    <h2>Neue Schichten</h2>
</header>
<nav id="nav-sub">
    <a href="shift.php?id_shift_type=<?php echo $placeholder['id_shift_type']?>" class="button">
        <i class="fa fa-chevron-left"></i> zurück
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Schichten</legend>
            <div>
                <label for="route">Route <small>(Pflichtfeld)</small></label>
                <input id="route" name="route" required placeholder="Wie heißt die Route?" value="<?php echo (isset($_POST['route']))? $_POST['route'] : '';?>">
            </div>
            <div>
                <label for="date_from">Datum <small>(Pflichtfeld)</small></label>
                <input id="date_from" type="date" name="date_from" required value="<?php echo (isset($_POST['date_from']))? $_POST['date_from'] : '';?>">
            </div>
            <div>
                <label for="time_from">Von <small>(Pflichtfeld)</small></label>
                <input id="time_from" type="time" name="time_from" required onchange="calculateShiftTimeTo()" value="<?php echo (isset($_POST['time_from']))? $_POST['time_from'] : '';?>">
            </div>
            <div>
                <label for="number">Schichtanzahl <small>(Pflichtfeld)</small></label>
                <input id="number" type="number" name="number" required onchange="calculateShiftTimeTo()" value="<?php echo (isset($_POST['number']))? (int)$_POST['number'] : 2;?>">
            </div>
            <div>
                <label for="hours_per_shift">Schichtlänge in Stunden <small>(Pflichtfeld)</small></label>
                <input id="hours_per_shift" type="number" name="hours_per_shift" required value="<?php echo (isset($_POST['hours_per_shift']))? (int)$_POST['hours_per_shift'] : 2;?>" onchange="calculateShiftTimeTo()">
            </div>
            <div>
                <label for="time_to">Bis</label>
                <input id="time_to" type="time" name="time_to" disabled>
            </div>

            <div>
                <label for="shiftday_series_until">Terminserie bis zum</label>
                <input id="shiftday_series_until" type="date" name="shiftday_series_until" value="<?php echo (isset($_POST['shiftday_series_until']))? $_POST['shiftday_series_until'] : '';?>">
            </div>
            <div>
                <label for="color_hex">Farbe</label>
                <input id="color_hex" type="color" name="color_hex" value="#d5c8e4" maxlength="7" required>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> speichern
            </button>
        </div>
    </form>
</div>
<script type="text/javascript" src="js/calculate_shift_datetime_to.js"></script>