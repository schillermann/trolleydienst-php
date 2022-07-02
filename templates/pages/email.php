<?php if (isset($placeholder['message'])) : ?>
    <div id="note-box" class="fade-in">
		<?php if (isset($placeholder['message']['success'])): ?>
            <p class="success">
				<?= $placeholder['message']['success'] ?>
            </p>
            <div id="note-box-content">
                <table>
					<?php foreach ($placeholder['user_list'] as $user): ?>
                        <tr>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                        </tr>
					<?php endforeach ?>
                </table>
            </div>
		<?php else: ?>
            <p class="error">
				<?= $placeholder['message']['error'] ?>
            </p>
		<?php endif;?>
        <button type="button" onclick="closeNoteBox()">
            <i class="fa fa-times"></i> <?= __('Close') ?>
        </button>
    </div>
<?php endif;?>

<header>
    <h2><?= __('Send Email') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./email-settings.php" class="button">
        <i class="fa fa-cog"></i> <?= __('Settings') ?>
    </a>
    <a href="./email-templates.php?id_email_template=1" class="button">
        <i class="fa fa-cog"></i> <?= __('Templates') ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?= __('To all users') ?></legend>
            <div>
                <label for="email_subject"><?= __('Subject') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="email_subject" name="email_subject" class="email-subject" required value="<?= $placeholder['email']['subject'] ?>">
            </div>
            <div>
                <label for=email_message><?= __('Message') ?> <small>(<?= __('Required') ?>)</small></label>
                <textarea id="email_message" name="email_message" rows="20" required><?= $placeholder['email']['message'];?></textarea>
            </div>

        </fieldset>
        <div class="from-button">
            <button name="send" class="active">
                <i class="fa fa-paper-plane"></i> <?= __('Send') ?>
            </button>
        </div>
</form>
</div>
