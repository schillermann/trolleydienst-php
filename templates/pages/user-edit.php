<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2> <?= __('Edit Publisher') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./user.php" class="button">
        <i class="fa fa-chevron-left"></i>  <?= __('Back') ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend> <?= __('Publisher') ?></legend>
            <div>
                <label for="is_active"> <?= __('Active') ?></label>
                <input id="is_active" type="checkbox" name="is_active" <?php if ($placeholder['user']['is_active']):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="is_admin"> <?= __('Admin Rights') ?></label>
                <input id="is_admin" type="checkbox" name="is_admin" <?php if ($placeholder['user']['is_admin']):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="username"> <?= __('Username') ?> <small>( <?= __('Required') ?>)</small></label>
                <input id="username" name="username" required value=" <?= $placeholder['user']['username'];?>">
            </div>
            <div>
                <label for="name"> <?= __('Name') ?> <small>( <?= __('Required') ?>)</small></label>
                <input id="name" name="name" required value=" <?= $placeholder['user']['name'];?>">
            </div>
            <div>
                <label for="email"> <?= __('Email') ?> <small>( <?= __('Required') ?>)</small></label>
                <input id="email" name="email" required value=" <?= $placeholder['user']['email'];?>">
            </div>
            <div>
                <label for="mobile"> <?= __('Mobile Number') ?></label>
                <input id="mobile" name="mobile" value=" <?= $placeholder['user']['mobile'];?>">
            </div>
            <div>
                <label for="phone"> <?= __('Phone Number') ?></label>
                <input id="phone" name="phone" value=" <?= $placeholder['user']['phone'];?>">
            </div>
            <div>
                <label for="congregation_name"> <?= __('Congregation') ?></label>
                <input id="congregation_name" name="congregation_name" value=" <?= $placeholder['user']['congregation_name'];?>">
            </div>
            <div>
                <label for="language"> <?= __('Language') ?></label>
                <input id="language" name="language" value=" <?= $placeholder['user']['language'];?>">
            </div>
            <div>
                <label for="note_admin"> <?= __('Admin Notes') ?></label>
                <textarea id="note_admin" name="note_admin" class="note"> <?= $placeholder['user']['note_admin'];?></textarea>
            </div>
            <div>
                <label for="note_user"> <?= __('Publisher Notes') ?></label>
                <textarea id="note_user" name="note_user" class="note" disabled> <?= $placeholder['user']['note_user'];?></textarea>
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
            <input type="hidden" name="name" value="<?php echo $placeholder['user']['name'];?>">
            <input type="hidden" name="username" value="<?php echo $placeholder['user']['username'];?>">
            <input type="hidden" name="email" value="<?php echo $placeholder['user']['email'];?>">
            <button name="resend_welcome_email" class="active">
            	<i class="fa fa-paper-plane"></i> <?php echo __('Resend Welcome Email'); ?>
            </button>
        </div>
    </form>
    <div id="footnote">
        <p><strong> <?= __('Updated on') ?>:</strong>  <?= $placeholder['user']['updated'];?> - <strong> <?= __('Created on') ?>:</strong>  <?= $placeholder['user']['created'];?></p>
    </div>
</div>