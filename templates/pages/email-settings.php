<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?php echo __("E-Mail Einstellungen"); ?></h2>
</header>
<nav id="nav-sub">
    <a href="./email.php" class="button">
        <i class="fa fa-chevron-left"></i> <?php echo __("zurück"); ?>
    </a>
</nav>
<div class="container-center">
    <h3><?php echo __("E-Mail Platzhalter"); ?></h3>
    <form method="post">
        <fieldset>
            <legend><?php echo __("E-Mail Platzhalter"); ?></legend>
            <div>
                <label for="email_address_from"><?php echo __("E-Mail Absenderadresse"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="email_address_from" type="email" name="email_address_from" required value="<?php echo $placeholder['email_address_from'];?>">
            </div>
            <div>
                <label for="email_address_reply"><?php echo __("E-Mail Adresse für Rückmeldungen"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="email_address_reply" type="email" name="email_address_reply" required value="<?php echo $placeholder['email_address_reply'];?>">
            </div>
            <div>
                <label for="congregation_name"><?php echo __("Name der Versammlung"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="congregation_name" name="congregation_name" required value="<?php echo $placeholder['congregation_name'];?>">
            </div>
            <div>
                <label for="application_name"><?php echo __("Name des Programms"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="application_name" name="application_name" required value="<?php echo $placeholder['application_name'];?>">
            </div>
            <div>
                <label for="team_name"><?php echo __("Name des Team"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="team_name" name="team_name" required value="<?php echo $placeholder['team_name'];?>">
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?php echo __("speichern"); ?>
            </button>
        </div>
    </form>
</div>