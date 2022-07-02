<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?= __('New Pubisher') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./user.php" class="button">
        <i class="fa fa-chevron-left"></i> <?= __('Back') ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?= __('Publisher') ?></legend>
            <div>
                <label for="is_admin"><?= __('Admin Rights') ?></label>
                <input id="is_admin" type="checkbox" name="is_admin" <?php if (isset($_POST['is_admin'])):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="username"><?= __('Username') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="username" name="username" required value="<?= (isset($_POST['username']))? $_POST['username'] : '';?>">
            </div>
            <div>
                <label for="name"><?= __('Name') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="name" name="name" required value="<?= (isset($_POST['name']))? $_POST['name'] : '';?>">
            </div>
            <div>
                <label for="email"><?= __('Email') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="email" name="email" required value="<?= (isset($_POST['email']))? $_POST['email'] : '';?>" placeholder="my@email.org">
            </div>
            <div>
                <label for="mobile"><?= __('Mobile Number') ?></label>
                <input id="mobile" name="mobile" value="<?= (isset($_POST['mobile']))? $_POST['mobile'] : '';?>">
            </div>
            <div>
                <label for="phone"><?= __('Phone Number') ?></label>
                <input id="phone" name="phone" value="<?= (isset($_POST['phone']))? $_POST['phone'] : '';?>">
            </div>
            <div>
                <label for="congregation_name"><?= __('Congregation') ?></label>
                <input id="congregation_name" name="congregation_name" value="<?= (isset($_POST['congregation_name']))? $_POST['congregation_name'] : '';?>">
            </div>
            <div>
                <label for="language"><?= __('Language') ?></label>
                <input id="language" name="language" value="<?= (isset($_POST['language']))? $_POST['language'] : '';?>">
            </div>
            <div>
                <label for="note_admin"><?= __('Admin Notes') ?></label>
                <textarea id="note_admin" name="note_admin" class="note"><?= (isset($_POST['note_admin']))? $_POST['note_admin'] : '';?></textarea>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?= __('Save') ?>
            </button>
        </div>
    </form>
</div>