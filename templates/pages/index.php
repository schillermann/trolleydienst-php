<?php include 'templates/pagesnippets/note-box.php' ?>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Anmelden</legend>
            <p>Wenn du ein Konto hast, bitte <em>Namen</em> und <em>Kennwort</em> eingeben.</p>
            <div>
                <label for="name">Name</label>
                <input id="name" name="name" tabindex="1" autocomplete="off">
            </div>
            <div>
                <label for="password">Kennwort</label>
                <input id="password" type="password" name="password" tabindex="2" autocomplete="off">
            </div>
            <div id="divForgotLink" class="login">
                <a href="/password-forgot.php" class="xsmall">Namen oder Kennwort vergessen?</a>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="login" class="active" tabindex="4">
                <i class="fa fa-sign-in" aria-hidden="true"></i> Anmelden
            </button>
        </div>
    </form>
</div>