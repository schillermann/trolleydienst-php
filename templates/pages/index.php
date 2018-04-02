<?php include 'templates/pagesnippets/note-box.php' ?>
<div class="container-center">
    <?php if(DEMO): ?>
        <div class="info-box">
            <p>Du kannst dich in der Demo Version mit folgenden Benutzern anmelden: </p>
            <dl>
                <dt>Benutzername</dt>
                <dd>admin</dd>
                <dt>Passwort</dt>
                <dd>demo</dd>
          </dl>
            <dl>
                <dt>Benutzername</dt>
                <dd>teilnehmer</dd>
                <dt>Passwort</dt>
                <dd>demo</dd>
          </dl>
        </div>
    <?php endif;?>
    <form method="post">
        <fieldset>
            <legend>Anmelden</legend>
            <p>Wenn du ein Konto hast, bitte <em>Benutzernamen</em> und <em>Passwort</em> eingeben.</p>
            <div>
                <label for="username">Benutzername</label>
                <input id="username" name="username" value="<?php echo $placeholder['username']; ?>">
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