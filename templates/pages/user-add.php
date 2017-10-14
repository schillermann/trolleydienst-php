<?php include 'templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Neuer Teilnehmer</h2>
</header>
<nav id="nav-sub">
    <a href="user.php" tabindex="10" class="button">
        <i class="fa fa-chevron-left"></i> zurück
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Teilnehmer</legend>
            <div>
                <label for="name">Name <small>(Pflichtfeld)</small></label>
                <input id="name" name="name" tabindex="1" required value="<?php echo (isset($_POST['name']))? $_POST['name'] : '';?>">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" name="email" tabindex="2" required value="<?php echo (isset($_POST['email']))? $_POST['email'] : '';?>">
            </div>
            <div>
                <label for="mobile">Handynr</label>
                <input id="mobile" name="mobile" tabindex="3" value="<?php echo (isset($_POST['mobile']))? $_POST['mobile'] : '';?>">
            </div>
            <div>
                <label for="phone">Telefonnr</label>
                <input id="phone" name="phone" tabindex="4" value="<?php echo (isset($_POST['phone']))? $_POST['phone'] : '';?>">
            </div>
            <div>
                <label for="congregation_name">Versammlung</label>
                <input id="congregation_name" name="congregation_name" tabindex="5" value="<?php echo (isset($_POST['congregation_name']))? $_POST['congregation_name'] : '';?>">
            </div>
            <div>
                <label for="language">Sprache</label>
                <input id="language" name="language" tabindex="6" value="<?php echo (isset($_POST['language']))? $_POST['language'] : '';?>">
            </div>
            <div>
                <label for="note_admin">Admin Bemerkung</label>
                <textarea id="note_admin" name="note_admin" class="note" tabindex="7"><?php echo (isset($_POST['note_admin']))? $_POST['note_admin'] : '';?></textarea>
            </div>
            <div>
                <label for="is_admin">Admin-Rechte</label>
                <input id="is_admin" type="checkbox" name="is_admin" tabindex="8" <?php if (isset($_POST['is_admin'])):?>checked<?php endif;?>>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active" tabindex="9">
                <i class="fa fa-floppy-o"></i> speichern
            </button>
        </div>
    </form>
</div>