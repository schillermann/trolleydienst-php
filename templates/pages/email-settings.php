<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?= __('Email Settings') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./email.php" class="button">
        <i class="fa fa-chevron-left"></i> <?= __('Back') ?>
    </a>
</nav>
<div class="container-center">
    <h3><?= __('Email Placeholders') ?></h3>
    <form method="post">
        <fieldset>
            <legend><?= __('Email Placeholders') ?></legend>
            <div>
                <label for="email_address_from"><?= __('Email Sender Address') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="email_address_from" type="email" name="email_address_from" required value="<?= $placeholder['email_address_from'];?>">
            </div>
            <div>
                <label for="email_address_reply"><?= __('Email Address for Replies') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="email_address_reply" type="email" name="email_address_reply" required value="<?= $placeholder['email_address_reply'];?>">
            </div>
            <div>
                <label for="congregation_name"><?= __('Congregation Name') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="congregation_name" name="congregation_name" required value="<?= $placeholder['congregation_name'];?>">
            </div>
            <div>
                <label for="application_name"><?= __('Application Name') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="application_name" name="application_name" required value="<?= $placeholder['application_name'];?>">
            </div>
            <div>
                <label for="team_name"><?= __('Team Name') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="team_name" name="team_name" required value="<?= $placeholder['team_name'];?>">
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?= __('Save') ?>
            </button>
        </div>
    </form>
</div>