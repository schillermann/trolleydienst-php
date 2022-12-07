<header>
    <h2><?= __('Send Newsletter') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./email-settings" class="button">
        <i class="fa fa-cog"></i> <?= __('Settings') ?>
    </a>
    <a href="./email-templates?id_email_template=1" class="button">
        <i class="fa fa-cog"></i> <?= __('Templates') ?>
    </a>
</nav>
<div class="container-center">

    <?php if (isset($_POST['send'])) : ?>
        <div class="info-box">
            <?php if (empty($placeholder['user_list'])) : ?>
                <p class="error"><?= __('No recipient email address was found!') ?></p>
            <?php else: ?>
                <p class="success"><?= __('The email has been sent to:') ?></p>
                <table>
					<?php foreach ($placeholder['user_list'] as $user): ?>
                        <tr>
                            <td><?= $user['first_name'] ?> <?= $user['last_name'] ?></td>
                            <td><?= $user['email'] ?></td>
                        </tr>
					<?php endforeach ?>
                </table>
            <?php endif ?>
        </div>
    <?php endif ?>

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
