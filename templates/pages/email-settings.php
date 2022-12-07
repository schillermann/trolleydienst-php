<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?= __('Email Settings') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./newsletter" class="button">
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
                <input id="email_address_from" type="email" name="email_address_from" required value="<?= $placeholder['email_address_from']; ?>">
            </div>
            <div>
                <label for="email_address_reply"><?= __('Email Address for Replies') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="email_address_reply" type="email" name="email_address_reply" required value="<?= $placeholder['email_address_reply']; ?>">
            </div>
            <div>
                <label for="congregation_name"><?= __('Congregation Name') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="congregation_name" name="congregation_name" required value="<?= $placeholder['congregation_name']; ?>">
            </div>
            <div>
                <label for="application_name"><?= __('Application Name') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="application_name" name="application_name" required value="<?= $placeholder['application_name']; ?>">
            </div>
            <div>
                <label for="team_name"><?= __('Team Name') ?> <small>(<?= __('Required') ?>)</small></label>
                <input id="team_name" name="team_name" required value="<?= $placeholder['team_name']; ?>">
            </div>
        </fieldset>

        <fieldset>
            <legend> <?= __('E-Mail')  ?></legend>
            <div>
                <label for="email_dispatch"> <?= __('E-Mail Delivery') ?></label>
                <select name="email_dispatch" id="email_dispatch" onchange="selectEmailMethod(this)">
                    <option value="phpmail" <?= $placeholder['email_dispatch'] === 'phpmail' ? 'selected' : ''?> >phpmail</option>
                    <option value="smtp" <?= $placeholder['email_dispatch'] === 'smtp' ? 'selected' : ''?> >smtp</option>
                    <option value="sendinblue" <?= $placeholder['email_dispatch'] === 'sendinblue' ? 'selected' : ''?> >sendinblue</option>
                </select>
            </div>
        </fieldset>

        <fieldset id="smtp">
            <legend> <?= __('SMTP')  ?></legend>
            <div>
                <label for="email_smtp_host"> <?= __('Host')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_smtp_host" name="email_smtp_host" type="text" value="<?= (isset($placeholder['email_smtp_host'])) ? $placeholder['email_smtp_host'] : '' ?>">
            </div>
            <div>
                <label for="email_smtp_username"> <?= __('Username')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_smtp_username" name="email_smtp_username" type="text" value="<?= (isset($placeholder['email_smtp_username'])) ? $placeholder['email_smtp_username'] : '' ?>">
            </div>
            <div>
                <label for="email_smtp_password"> <?= __('Password')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_smtp_password" name="email_smtp_password" type="password" value="<?= (isset($placeholder['email_smtp_password'])) ? $placeholder['email_smtp_password'] : '' ?>">
            </div>
            <div>
                <label for="email_smtp_port"> <?= __('Port')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <select name="email_smtp_port" id="email_smtp_port">
                    <option value="25">25</option>
                    <option value="587" selected>587</option>
                    <option value="465">465</option>
                    <option value="2525">2525</option>
                </select>
            </div>
            <div>
                <label for="email_smtp_encryption"> <?= __('Encryption')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_smtp_encryption" name="email_smtp_encryption" list="email_smtp_encryption_list" type="text" value="<?= (isset($placeholder['email_smtp_encryption'])) ? $placeholder['email_smtp_encryption'] : '' ?>">
                <datalist id="email_smtp_encryption_list">
                    <option>STARTTLS</option>
                    <option>STARTTLS/TLS</option>
                    <option>SSL</option>
                    <option>SSL/TLS</option>
                    <option>TLS</option>
                </datalist>
            </div>
        </fieldset>

        <fieldset id="sendinblue">
            <legend> <?= __('Sendinblue')  ?></legend>
            <div>
                <label for="email_sendinblue_api_key"> <?= __('API Key')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_sendinblue_api_key" name="email_sendinblue_api_key" type="text" value="<?= (isset($placeholder['email_sendinblue_api_key'])) ? $placeholder['email_sendinblue_api_key'] : '' ?>">
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?= __('Save') ?>
            </button>
        </div>
    </form>
</div>
<script>
    const sendinblue = document.getElementById('sendinblue');
    const smtp = document.getElementById('smtp');
    sendinblue.style.display = 'none';
    smtp.style.display = 'none';

    function selectEmailMethod(method) {

        if (method.value === 'smtp') {
            sendinblue.style.display = 'none';
            smtp.style.display = 'block';
            return;
        }

        if (method.value === 'sendinblue') {
            sendinblue.style.display = 'block';
            smtp.style.display = 'none';
            return;
        }

        sendinblue.style.display = 'none';
        smtp.style.display = 'none';
    }

    window.onload = function(event) {
        selectEmailMethod(document.getElementById('email_dispatch'));
    }
</script>