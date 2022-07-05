<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?= __('Profile') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./profile.php" class="button active">
        <i class="fa fa-user"></i> <?= __('Profile') ?>
    </a>
    <a href="./profile-password.php" class="button">
        <i class="fa fa-lock"></i> <?= __('Password') ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?= __('Contact Details') ?></legend>
            <div>
                <label for="username"><?= __('Username') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="username" name="username" required value="<?= $placeholder['profile']['username'] ?>">
            </div>
            <div>
                <label for="name"><?= __('Name') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="name" name="name" required value="<?= $placeholder['profile']['name'] ?>">
            </div>
            <div>
                <label for="email"><?= __('Email') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="email" type="email" name="email" required value="<?= $placeholder['profile']['email'] ?>">
            </div>
            <div>
                <label for="phone"><?= __('Phone') ?></label>
                <input id="phone" type="tel" name="phone" value="<?= $placeholder['profile']['phone'] ?>">
            </div>
            <div>
                <label for="mobile"><?= __('Mobile') ?></label>
                <input id="mobile" type="tel" name="mobile" value="<?= $placeholder['profile']['mobile'] ?>">
            </div>
            <div>
                <label for="congregation_name"><?= __('Congregation') ?></label>
                <input id="congregation_name" name="congregation_name" value="<?= $placeholder['profile']['congregation_name'] ?>">
            </div>
            <div>
                <label for="language"><?= __('Language') ?></label>
                <input id="language" name="language" value="<?= $placeholder['profile']['language'] ?>">
            </div>
            <div>
                <label for="note_user"><?= __('Notes') ?></label>
                <textarea id="note_user" name="note_user" class="note"><?= $placeholder['profile']['note_user'] ?></textarea>
            </div>

        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?= __('Save Profile') ?>
            </button>
        </div>
    </form>
</div>