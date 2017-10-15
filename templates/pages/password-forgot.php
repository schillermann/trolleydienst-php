<?php include 'templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Passwort vergessen</h2>
</header>
<nav id="nav-sub">
    <a href="index.php" tabindex="4" class="button">
        <i class="fa fa-chevron-left"></i> zurück
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Passwort anfordern</legend>
            <div>
                <label for="name">Name <small>(Pflichtfeld)</small></label>
                <input id="name" name="name" tabindex="1" required">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" type="email" name="email" tabindex="2" required>
            </div>

        </fieldset>
        <div class="from-button">
            <button name="password_reset" class="active" tabindex="3">
                <i class="fa fa-undo"></i> Neues Passwort anfordern
            </button>
        </div>
    </form>
</div>