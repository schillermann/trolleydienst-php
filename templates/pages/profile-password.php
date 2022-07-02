<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?= __('Profile') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./profile.php" class="button">
        <i class="fa fa-user"></i> <?= __('Profile') ?>
    </a>
    <a href="./profile-password.php" class="button active">
        <i class="fa fa-lock"></i> <?= __('Password') ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?= __('Password') ?></legend>
            <div>
                <label for="password"><?= __('New Password') ?></label>
                <input id="password" type="password" name="password">
            </div>
            <div>
                <label for="password_repeat"><?= __('Repeat Password') ?></label>
                <input id="password_repeat" type="password" name="password_repeat">
            </div>

        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?= __('Save Password') ?>
            </button>
        </div>
    </form>
</div>