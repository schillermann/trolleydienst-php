<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2> <?= __('Edit Publisher') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./publishers" class="button">
        <i class="fa fa-chevron-left"></i>  <?= __('Back') ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend> <?= __('Publisher') ?></legend>
            <div>
                <label for="active"> <?= __('Active') ?></label>
                <input id="active" type="checkbox" name="active" <?php if ($placeholder['user']['active']):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="administrative"> <?= __('Admin Rights') ?></label>
                <input id="administrative" type="checkbox" name="administrative" <?php if ($placeholder['user']['administrative']):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="username"> <?= __('Username') ?> <small>( <?= __('Required') ?>)</small></label>
                <input id="username" name="username" required value="<?= $placeholder['user']['username'];?>">
            </div>
            <div>
                <label for="first_name"> <?= __('First Name') ?> <small>( <?= __('Required') ?>)</small></label>
                <input id="first_name" name="first_name" required value="<?= $placeholder['user']['first_name'];?>">
            </div>
            <div>
                <label for="last_name"> <?= __('Last Name') ?> <small>( <?= __('Required') ?>)</small></label>
                <input id="last_name" name="last_name" required value="<?= $placeholder['user']['last_name'];?>">
            </div>
            <div>
                <label for="email"> <?= __('Email') ?> <small>( <?= __('Required') ?>)</small></label>
                <input id="email" name="email" required value="<?= $placeholder['user']['email'];?>">
            </div>
            <div>
                <label for="mobile"> <?= __('Mobile Number') ?></label>
                <input id="mobile" name="mobile" value="<?= $placeholder['user']['mobile'];?>">
            </div>
            <div>
                <label for="phone"> <?= __('Phone Number') ?></label>
                <input id="phone" name="phone" value="<?= $placeholder['user']['phone'];?>">
            </div>
            <div>
                <label for="congregation_name"> <?= __('Congregation') ?></label>
                <input id="congregation_name" name="congregation_name" value="<?= $placeholder['user']['congregation'];?>">
            </div>
            <div>
                <label for="language"> <?= __('Language') ?></label>
                <input id="language" name="language" value="<?= $placeholder['user']['language'];?>">
            </div>
            <div>
                <label for="admin_note"> <?= __('Admin Notes') ?></label>
                <textarea id="admin_note" name="admin_note" class="note"><?= $placeholder['user']['admin_note'];?></textarea>
            </div>
            <div>
                <label for="publisher_note"> <?= __('Publisher Notes') ?></label>
                <textarea id="publisher_note" name="publisher_note" class="note" disabled> <?= $placeholder['user']['publisher_note'];?></textarea>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i>  <?= __('Save') ?>
            </button>
            <button name="delete" class="warning">
                <i class="fa fa-trash-o"></i>  <?= __('Delete') ?>
            </button>
        </div>
    </form>
    <form method="post">
        <fieldset>
            <legend> <?= __('Password') ?></legend>
            <div>
                <label for="password"> <?= __('New Password') ?></label>
                <input id="password" type="password" name="password">
            </div>
            <div>
                <label for="password_repeat"> <?= __('Repeat Password') ?></label>
                <input id="password_repeat" type="password" name="password_repeat">
            </div>

        </fieldset>
        <div class="from-button">
            <button name="password_save" class="active">
                <i class="fa fa-floppy-o"></i>  <?= __('Save Password') ?>
            </button>
            <input type="hidden" name="first_name" value="<?php echo $placeholder['user']['first_name'];?>">
            <input type="hidden" name="last_name" value="<?php echo $placeholder['user']['last_name'];?>">
            <input type="hidden" name="username" value="<?php echo $placeholder['user']['username'];?>">
            <input type="hidden" name="email" value="<?php echo $placeholder['user']['email'];?>">
            <button name="resend_welcome_email" class="active">
            	<i class="fa fa-paper-plane"></i> <?php echo __('Resend Welcome Email'); ?>
            </button>
        </div>
    </form>
    <div id="footnote">
        <p><strong> <?= __('Updated on') ?>:</strong>  <?= $placeholder['user']['updated_on'];?> - <strong> <?= __('Created on') ?>:</strong>  <?= $placeholder['user']['created_on'];?></p>
    </div>
</div>