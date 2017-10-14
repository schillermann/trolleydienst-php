<?php include 'templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Profil</h2>
</header>
<nav id="nav-sub">
    <a href="profile.php" class="button active">
        <i class="fa fa-user"></i> Benutzerdaten
    </a>
    <a href="profile-password.php" class="button">
        <i class="fa fa-lock"></i> Passwort
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Kontaktdaten</legend>
            <div>
                <label for="name">Name <small>(Pflichtfeld)</small></label>
                <input id="name" name="name" tabindex="1" required value="<?php echo $placeholder['profile']['name']; ?>">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" type="email" name="email" tabindex="3" required value="<?php echo $placeholder['profile']['email']; ?>">
            </div>
            <div>
                <label for="phone">Telefon</label>
                <input id="phone" type="tel" name="phone" tabindex="5" value="<?php echo $placeholder['profile']['phone']; ?>">
            </div>
            <div>
                <label for="mobile">Handy</label>
                <input id="mobile" type="tel" name="mobile" tabindex="6" value="<?php echo $placeholder['profile']['mobile']; ?>">
            </div>
            <div>
                <label for="congregation_name">Versammlung</label>
                <input id="congregation_name" name="congregation_name" tabindex="7" value="<?php echo $placeholder['profile']['congregation_name']; ?>">
            </div>
            <div>
                <label for="language">Sprache</label>
                <input id="language" name="language" tabindex="8" value="<?php echo $placeholder['profile']['language']; ?>">
            </div>
            <div>
                <label for="note_user">Bemerkung</label>
                <textarea id="note_user" name="note_user" class="note" tabindex="10"><?php echo $placeholder['profile']['note_user']; ?></textarea>
            </div>

        </fieldset>
        <div class="from-button">
            <button name="save" class="active" tabindex="11">
                <i class="fa fa-floppy-o"></i> Profil speichern
            </button>
        </div>
    </form>
</div>