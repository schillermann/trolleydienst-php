<?php
    include('../templates/pagesnippets/note-box.php');
    $language = include('../helpers/get_language.php');
?>
<header>
    <h2> <?= __('Installation')  ?></h2>
</header>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend> <?= __('Admin')  ?></legend>
            <div>
                <label for="name"> <?= __('Name') ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="name" name="name" required value="<?= (isset($_POST['name']))? $_POST['name'] : '' ?>">
            </div>
            <div>
                <label for="username"> <?= __('Username')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="username" name="username" required value="<?= (isset($_POST['username']))? $_POST['username'] : '' ?>">
            </div>
            <div>
                <label for="email"> <?= __('Email')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email" name="email" required oninput="insertEmail(this)" value="<?= (isset($_POST['email']))? $_POST['email'] : '' ?>" placeholder="my@email.org">
            </div>
            <div>
                <label for="password"> <?= __('Password')  ?></label>
                <input id="password" type="password" name="password">
            </div>
            <div>
                <label for="password_repeat"> <?= __('Repeat Password') ?></label>
                <input id="password_repeat" type="password" name="password_repeat">
            </div>
        </fieldset>
        <fieldset>
            <legend> <?= __('Settings')  ?></legend>
            <div>
                <label for="language"> <?= __('Language') ?></label>
                <select name="language" id="language">
                    <option value="en" <?= ('en' === $language)? 'selected': ''?>><?= __('English') ?></option>
                    <option value="de" <?= ('de' === $language)? 'selected': ''?>><?= __('German') ?></option>
                </select>
            </div>
            <div>
                <label for="email_address_from"> <?= __('Sender Email Address')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_address_from" name="email_address_from" required placeholder="absender@email.de" value="<?= (isset($_POST['email_address_from']))? $_POST['email_address_from'] : 'no-reply@' . $_SERVER['SERVER_NAME'] ?>">
            </div>
            <div>
                <label for="email_address_reply"> <?= __('Reply Email Address')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_address_reply" name="email_address_reply" required placeholder="antwort@email.de" value="<?= (isset($_POST['email_address_reply']))? $_POST['email_address_reply'] : '' ?>">
            </div>
            <div>
                <label for="application_name"> <?= __('Application Name')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="application_name" name="application_name" required value="<?= (isset($_POST['application_name']))? $_POST['application_name'] : __('Public Witnessing') ?>">
            </div>
            <div>
                <label for="team_name"> <?= __('Team Name')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="team_name" name="team_name" required value="<?= (isset($_POST['team_name']))? $_POST['team_name'] : __('Litcart Team') ?>">
            </div>
            <div>
                <label for="congregation_name"> <?= __('Congregation Name')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="congregation_name" name="congregation_name" required placeholder=" <?= __('Example Congregation')  ?>" value=" <?= (isset($_POST['congregation_name']))? $_POST['congregation_name'] : '';?>">
            </div>
        </fieldset>
        <div class="from-button">
            <button name="install" class="active">
                <i class="fa fa-download"></i>  <?= __('Install')  ?>
            </button>
        </div>
    </form>
</div>
<script>
    function insertEmail(email) {
        document.getElementById('email_address_reply').value = email.value;
    }
</script>