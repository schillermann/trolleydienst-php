<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Neuer Schichttyp</h2>
</header>
<nav id="nav-sub">
    <a href="./shifttype.php" class="button">
        <i class="fa fa-chevron-left"></i> zurück
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Schichtart</legend>
            <div>
                <label for="name">Name <small>(Pflichtfeld)</small></label>
                <input id="name" name="name" required value="<?php echo (isset($_POST['name']))? $_POST['name'] : '';?>">
            </div>
            <div>
                <label for="user_per_shift_max">Max. Teilnehmer <small>(Pflichtfeld)</small></label>
                <input id="user_per_shift_max" type="number" name="user_per_shift_max" required value="<?php echo (isset($_POST['user_per_shift_max']))? $_POST['user_per_shift_max'] : 2;?>">
            </div>
            <div>
                <label for="shift_type_info">Info</label>
                <textarea id="shift_type_info" name="shift_type_info" class="note"><?php echo (isset($_POST['shift_type_info']))? $_POST['shift_type_info'] : '';?></textarea>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> speichern
            </button>
        </div>
    </form>
</div>