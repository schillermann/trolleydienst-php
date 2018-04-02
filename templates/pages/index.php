<?php include 'templates/pagesnippets/note-box.php' ?>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Anmelden</legend>
            <p>Wenn du ein Konto hast, bitte <em>Benutzernamen</em> und <em>Passwort</em> eingeben.</p>
            <div>
                <label for="username">Benutzername</label>
                <input id="username" name="username">
            </div>
            <div>
                <label for="password">Passwort</label>
                <input id="password" type="password" name="password" autocomplete="off">
            </div>
            <div id="divForgotLink" class="login">
                <a href="/password-forgot.php" class="xsmall">Passwort vergessen</a>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="login" class="active">
                <i class="fa fa-sign-in"></i> Anmelden
            </button>
        </div>
    </form>
</div>