<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?php echo __("Neuer Teilnehmer"); ?></h2>
</header>
<nav id="nav-sub">
    <a href="./user.php" class="button">
        <i class="fa fa-chevron-left"></i> <?php echo __("zurück"); ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?php echo __("Teilnehmer"); ?></legend>
            <div>
                <label for="is_admin"><?php echo __("Admin-Rechte"); ?></label>
                <input id="is_admin" type="checkbox" name="is_admin" <?php if (isset($_POST['is_admin'])):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="username"><?php echo __("Benutzername"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="username" name="username" required value="<?php echo (isset($_POST['username']))? $_POST['username'] : '';?>">
            </div>
            <div>
                <label for="name"><?php echo __("Name"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="name" name="name" required value="<?php echo (isset($_POST['name']))? $_POST['name'] : '';?>">
            </div>
            <div>
                <label for="email"><?php echo __("E-Mail"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="email" name="email" required value="<?php echo (isset($_POST['email']))? $_POST['email'] : '';?>" placeholder="my@email.org">
            </div>
            <div>
                <label for="mobile"><?php echo __("Handynr"); ?></label>
                <input id="mobile" name="mobile" value="<?php echo (isset($_POST['mobile']))? $_POST['mobile'] : '';?>">
            </div>
            <div>
                <label for="phone"><?php echo __("Telefonnr"); ?></label>
                <input id="phone" name="phone" value="<?php echo (isset($_POST['phone']))? $_POST['phone'] : '';?>">
            </div>
            <div>
                <label for="congregation_name"><?php echo __("Versammlung"); ?></label>
                <input id="congregation_name" name="congregation_name" value="<?php echo (isset($_POST['congregation_name']))? $_POST['congregation_name'] : '';?>">
            </div>
            <div>
                <label for="language"><?php echo __("Sprache"); ?></label>
                <input id="language" name="language" value="<?php echo (isset($_POST['language']))? $_POST['language'] : '';?>">
            </div>
            <div>
                <label for="note_admin"><?php echo __("Admin Bemerkung"); ?></label>
                <textarea id="note_admin" name="note_admin" class="note"><?php echo (isset($_POST['note_admin']))? $_POST['note_admin'] : '';?></textarea>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?php echo __("speichern"); ?>
            </button>
        </div>
    </form>
</div>