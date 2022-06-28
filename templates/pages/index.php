<?php include '../templates/pagesnippets/note-box.php' ?>
<div class="container-center">
    <?php if(DEMO): ?>
        <div class="info-box">
            <p><?php echo __("Du kannst dich in der Demo Version mit folgenden Benutzern anmelden:") ?> </p>
            <dl>
                <dt><?php echo __("Benutzername"); ?></dt>
                <dd>admin</dd>
                <dt><?php echo __("Passwort"); ?></dt>
                <dd>demo</dd>
          </dl>
            <dl>
                <dt><?php echo __("Benutzername"); ?></dt>
                <dd>teilnehmer</dd>
                <dt><?php echo __("Passwort"); ?></dt>
                <dd>demo</dd>
          </dl>
        </div>
    <?php endif;?>
    <form method="post">
        <fieldset>
            <legend><?php echo __("Anmelden"); ?></legend>
            <p><?php echo __("Bitte melde dich mit deinen Zugangsdaten an."); ?></p>
            <div>
                <label for="email_or_username"><?php echo __("E-Mail oder Benutzername"); ?></label>
                <input id="email_or_username" name="email_or_username" value="<?php echo $placeholder['email_or_username']; ?>" required>
            </div>
            <div>
                <label for="password"><?php echo __("Passwort"); ?></label>
                <input id="password" type="password" name="password" autocomplete="off" required>
            </div>
            <div id="divForgotLink" class="login">
                <a href="./password-forgot.php" class="xsmall"><?php echo __("Password vergessen"); ?></a>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="login" class="active">
                <i class="fa fa-sign-in"></i> <?php echo __("Anmelden"); ?>
            </button>
        </div>
    </form>
</div>