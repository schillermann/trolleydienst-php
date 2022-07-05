<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?= __('Forgot password') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./" class="button">
        <i class="fa fa-chevron-left"></i> <?= __('Back') ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?= __('Request Password Reset') ?></legend>
            <div>
                <label for="username"><?= __('Username') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="username" name="username" required>
            </div>
            <div>
                <label for="email"><?= __('Email') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="email" type="email" name="email" required>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="password_reset" class="active">
                <i class="fa fa-undo"></i> <?= __('Request new password') ?>
            </button>
        </div>
    </form>
</div>