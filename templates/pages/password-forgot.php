<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Passwort vergessen</h2>
</header>
<nav id="nav-sub">
    <a href="./" class="button">
        <i class="fa fa-chevron-left"></i> zurück
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Passwort anfordern</legend>
            <div>
                <label for="username">Benutzername <small>(Pflichtfeld)</small></label>
                <input id="username" name="username" required>
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" type="email" name="email" required>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="password_reset" class="active">
                <i class="fa fa-undo"></i> Neues Passwort anfordern
            </button>
        </div>
    </form>
</div>