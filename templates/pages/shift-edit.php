<?php include 'templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Schichten bearbeiten</h2>
</header>
<nav id="nav-sub">
    <a href="shift.php?id_shift_type=<?php echo $placeholder['id_shift_type'];?>" class="button">
        <i class="fa fa-chevron-left"></i> zurück
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Schichten</legend>
            <div>
                <label for="route">Route <small>(Pflichtfeld)</small></label>
                <input id="route" name="route" required value="<?php echo $placeholder['route'];?>">
            </div>
            <div>
                <label for="date_from">Datum <small>(Pflichtfeld)</small></label>
                <input id="date_from" type="date" name="date_from" required value="<?php echo $placeholder['date_from'];?>">
            </div>
            <div>
                <label for="time_from">Von <small>(Pflichtfeld)</small></label>
                <input id="time_from" type="time" name="time_from" required onchange="calculateShiftTimeTo()" value="<?php echo $placeholder['time_from'];?>">
            </div>
            <div>
                <label for="number">Schichtanzahl <small>(Pflichtfeld)</small></label>
                <input id="number" type="number" name="number" required value="<?php echo $placeholder['number'];?>" disabled>
            </div>
            <div>
                <label for="hours_per_shift">Schichtlänge in Stunden <small>(Pflichtfeld)</small></label>
                <input id="hours_per_shift" type="number" name="hours_per_shift" required value="<?php echo $placeholder['hours_per_shift'];?>" onchange="calculateShiftTimeTo()" value="<?php echo $placeholder['hours_per_shift'];?>">
            </div>
            <div>
                <label for="time_to">Bis</label>
                <input id="time_to" type="time" name="time_to" disabled>
            </div>
            <div>
                <label for="color_hex">Farbe</label>
                <input id="color_hex" type="color" name="color_hex" maxlength="5" required value="<?php echo $placeholder['color_hex'];?>">
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> speichern
            </button>
            <button name="delete" class="warning">
                <i class="fa fa-trash-o"></i> löschen
            </button>
        </div>
    </form>
    <div id="footnote">
        <p><strong>Geändert am:</strong> <?php echo $placeholder['updated'];?> - <strong>Erstellt am:</strong> <?php echo $placeholder['created'];?></p>
    </div>
</div>
<script type="text/javascript" src="js/calculate_shift_datetime_to.js"></script>
<script>
    calculateShiftTimeTo();
</script>