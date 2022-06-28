<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?php echo __("Installation"); ?></h2>
</header>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?php echo __("Admin"); ?></legend>
            <div>
                <label for="name"><?php echo __("Name"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="name" name="name" required value="<?= (isset($_POST['name']))? $_POST['name'] : '' ?>">
            </div>
            <div>
                <label for="username"><?php echo __("Benutzername"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="username" name="username" required value="<?= (isset($_POST['username']))? $_POST['username'] : '' ?>">
            </div>
            <div>
                <label for="email"><?php echo __("E-Mail"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="email" name="email" required oninput="insertEmail(this)" value="<?= (isset($_POST['email']))? $_POST['email'] : '' ?>" placeholder="my@email.org">
            </div>
            <div>
                <label for="password"><?php echo __("Passwort"); ?></label>
                <input id="password" type="password" name="password">
            </div>
            <div>
                <label for="password_repeat"><?php echo __("Passwort"); ?> (<?php echo __("wiederholen"); ?>)</label>
                <input id="password_repeat" type="password" name="password_repeat">
            </div>
        </fieldset>
        <fieldset>
            <legend><?php echo __("Einstellungen"); ?></legend>
            <div>
                <label for="email_address_from"><?php echo __("E-Mail Server Absender Adresse"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="email_address_from" name="email_address_from" required placeholder="absender@email.de" value="<?= (isset($_POST['email_address_from']))? $_POST['email_address_from'] : 'no-reply@' . $_SERVER['SERVER_NAME'] ?>">
            </div>
            <div>
                <label for="email_address_reply"><?php echo __("E-Mail Antwort Adresse"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="email_address_reply" name="email_address_reply" required placeholder="antwort@email.de" value="<?= (isset($_POST['email_address_reply']))? $_POST['email_address_reply'] : '' ?>">
            </div>
            <div>
                <label for="application_name"><?php echo __("Name der Anwendung"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="application_name" name="application_name" required value="<?= (isset($_POST['application_name']))? $_POST['application_name'] : __('Öffentliches Zeugnisgeben') ?>">
            </div>
            <div>
                <label for="team_name"><?php echo __("Team Name"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="team_name" name="team_name" required value="<?= (isset($_POST['team_name']))? $_POST['team_name'] : __('Trolley Team') ?>">
            </div>
            <div>
                <label for="congregation_name"><?php echo __("Name der Versammlung"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="congregation_name" name="congregation_name" required placeholder="<?php echo __("Muster Versammlung"); ?>" value="<?php echo (isset($_POST['congregation_name']))? $_POST['congregation_name'] : '';?>">
            </div>
        </fieldset>
        <div class="from-button">
            <button name="install" class="active">
                <i class="fa fa-download"></i> <?php echo __("installieren"); ?>
            </button>
        </div>
    </form>
</div>
<script>
    function insertEmail(email) {
        document.getElementById('email_address_reply').value = email.value;
    }
</script>