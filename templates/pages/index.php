<?php include '../templates/pagesnippets/note-box.php' ?>
<div class="container-center">
    <?php if (DEMO) : ?>
        <div class="info-box">
            <p><?= __('In the demo version you can log in with the following users:') ?> </p>
            <dl>
                <dt><?= __('Username') ?></dt>
                <dd>admin</dd>
                <dt><?= __('Password') ?></dt>
                <dd>demo</dd>
            </dl>
            <dl>
                <dt><?= __('Username') ?></dt>
                <dd>teilnehmer</dd>
                <dt><?= __('Password') ?></dt>
                <dd>demo</dd>
            </dl>
        </div>
    <?php endif; ?>
    <?php if (MAINTENANCE) : ?>
        <div class="info-box">
            <h1><?= __('We will be back soon!'); ?></h1>
            <p><?= __('We are performing some necessary maintenance and will be be back soon. We apologise for the inconvenience.'); ?></p>
            <p>- <?= TEAM_NAME; ?></p>
        </div>

    <?php else :; ?>
        <form method="post">
            <fieldset>
                <legend><?= __('Login') ?></legend>
                <p><?= __('Please log in with your login details.') ?></p>
                <div>
                    <label for="email_or_username"><?= __('Email or username') ?></label>
                    <input id="email_or_username" name="email_or_username" value="<?= $placeholder['email_or_username'] ?>" required>
                </div>
                <div>
                    <label for="password"><?= __('Password') ?></label>
                    <input id="password" type="password" name="password" autocomplete="off" required>
                </div>
                <div id="divForgotLink" class="login">
                    <a href="./reset-password" class="xsmall"><?= __('Forgot password') ?></a>
                </div>
            </fieldset>
            <div class="from-button">
                <button name="login" class="active">
                    <i class="fa fa-sign-in"></i> <?= __('Login') ?>
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>