<?php include 'templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Profil</h2>
</header>
<nav id="nav-sub">
    <a href="profile.php" class="button">
        <i class="fa fa-user"></i> Benutzerdaten
    </a>
    <a href="profile-password.php" class="button active">
        <i class="fa fa-lock"></i> Passwort
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Passwort</legend>
            <div>
                <label for="password">Neues Passwort</label>
                <input id="password" type="password" name="password">
            </div>
            <div>
                <label for="password_repeat">Neues Passwort (wiederholen)</label>
                <input id="password_repeat" type="password" name="password_repeat">
            </div>

        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> Passwort ändern
            </button>
        </div>
    </form>
</div>