<?php include 'templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Installation</h2>
</header>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Admin</legend>
            <div>
                <label for="username">Benutzername <small>(Pflichtfeld)</small></label>
                <input id="username" name="username" required value="<?php echo (isset($_POST['username']))? $_POST['username'] : 'admin';?>">
            </div>
            <div>
                <label for="name">Name <small>(Pflichtfeld)</small></label>
                <input id="name" name="name" required value="<?php echo (isset($_POST['name']))? $_POST['name'] : '';?>">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" name="email" required oninput="insertEmail(this)" value="<?php echo (isset($_POST['email']))? $_POST['email'] : '';?>" placeholder="my@email.org">
            </div>
            <div>
                <label for="password">Passwort</label>
                <input id="password" type="password" name="password">
            </div>
            <div>
                <label for="password_repeat">Passwort (wiederholen)</label>
                <input id="password_repeat" type="password" name="password_repeat">
            </div>
        </fieldset>
        <fieldset>
            <legend>Einstellungen</legend>
            <div>
                <label for="email_address_from">E-Mail Server Absender Adresse <small>(Pflichtfeld)</small></label>
                <input id="email_address_from" name="email_address_from" required placeholder="absender@email.de" value="<?php echo (isset($_POST['email_address_from']))? $_POST['email_address_from'] : 'no-reply@' . $_SERVER['SERVER_NAME'];?>">
            </div>
            <div>
                <label for="email_address_reply">E-Mail Antwort Adresse <small>(Pflichtfeld)</small></label>
                <input id="email_address_reply" name="email_address_reply" required placeholder="antwort@email.de" value="<?php echo (isset($_POST['email_address_reply']))? $_POST['email_address_reply'] : '';?>">
            </div>
            <div>
                <label for="application_name">Name der Anwendung <small>(Pflichtfeld)</small></label>
                <input id="application_name" name="application_name" required value="<?php echo (isset($_POST['application_name']))? $_POST['application_name'] : 'Öffentliches Zeugnisgeben';?>">
            </div>
            <div>
                <label for="team_name">Team Name <small>(Pflichtfeld)</small></label>
                <input id="team_name" name="team_name" required value="<?php echo (isset($_POST['team_name']))? $_POST['team_name'] : 'Trolley Team';?>">
            </div>
            <div>
                <label for="congregation_name">Name der Versammlung <small>(Pflichtfeld)</small></label>
                <input id="congregation_name" name="congregation_name" required placeholder="Muster Versammlung" value="<?php echo (isset($_POST['congregation_name']))? $_POST['congregation_name'] : '';?>">
            </div>
        </fieldset>
        <div class="from-button">
            <button name="install" class="active">
                <i class="fa fa-download"></i> installieren
            </button>
        </div>
    </form>
</div>
<script>
    function insertEmail(email) {
        document.getElementById('email_address_reply').value = email.value;
    }
</script>