<?php include '../templates/pagesnippets/note-box.php' ?>
<div class="container-center">
    <?php if ($params['error']) : ?>
    <div class="info-box">
        <p>
            <?= $params['error'] ?>
        </p>
    </div>
    <?php endif; ?>
    <form method="post">
        <fieldset>
            <legend>Anmelden</legend>
            <p>Bitte melde dich mit deinen Zugangsdaten an.</p>
            <div>
                <label for="email_or_username">E-Mail oder Benutzername</label>
                <input id="email_or_username" name="email_or_username" value="<?= 'email' ?>" required>
            </div>
            <div>
                <label for="password">Passwort</label>
                <input id="password" type="password" name="password" autocomplete="off" required>
            </div>
            <div id="divForgotLink" class="login">
                <a href="./password-forgot.php" class="xsmall">Passwort vergessen</a>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="login" class="active">
                <i class="fa fa-sign-in"></i> Anmelden
            </button>
        </div>
    </form>
</div>