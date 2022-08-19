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
                <label for="first_name"> <?= __('First Name') ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="first_name" name="first_name" type="text" required value="<?= (isset($_POST['first_name']))? $_POST['first_name'] : '' ?>">
            </div>
            <div>
                <label for="last_name"> <?= __('Last Name') ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="last_name" name="last_name" type="text" required value="<?= (isset($_POST['last_name']))? $_POST['last_name'] : '' ?>">
            </div>
            <div>
                <label for="username"> <?= __('Username')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="username" name="username" type="text" required value="<?= (isset($_POST['username']))? $_POST['username'] : '' ?>">
            </div>
            <div>
                <label for="email"> <?= __('Email')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email" name="email" type="email" required oninput="insertEmail(this)" value="<?= (isset($_POST['email']))? $_POST['email'] : '' ?>" placeholder="my@email.org">
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
            <legend> <?= __('E-Mail')  ?></legend>
            <div>
                <label for="delivery_method"> <?= __('E-Mail Delivery') ?></label>
                <select name="delivery_method" id="delivery_method" onchange="selectEmailMethod(this)">
                    <option value="phpmail" selected>phpmail</option>
                    <option value="smtp">smtp</option>
                    <option value="sendinblue">sendinblue</option>
                </select>
            </div>
            <div>
                <label for="email_address_from"> <?= __('Sender Email Address')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_address_from" name="email_address_from" type="email" required placeholder="absender@email.de" value="<?= (isset($_POST['email_address_from']))? $_POST['email_address_from'] : 'no-reply@' . $_SERVER['SERVER_NAME'] ?>">
            </div>
            <div>
                <label for="email_address_reply"> <?= __('Reply Email Address')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_address_reply" name="email_address_reply" type="email" required placeholder="antwort@email.de" value="<?= (isset($_POST['email_address_reply']))? $_POST['email_address_reply'] : '' ?>">
            </div>
            
        </fieldset>

        <fieldset id="smtp">
            <legend> <?= __('SMTP')  ?></legend>
            <div>
                <label for="email_smtp_host"> <?= __('Host')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_smtp_host" name="email_smtp_host" type="text" value="<?= (isset($_POST['email_smtp_host']))? $_POST['email_smtp_host'] : '' ?>">
            </div>
            <div>
                <label for="email_smtp_username"> <?= __('Username')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_smtp_username" name="email_smtp_username" type="text" value="<?= (isset($_POST['email_smtp_username']))? $_POST['email_smtp_username'] : '' ?>">
            </div>
            <div>
                <label for="email_smtp_password"> <?= __('Password')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_smtp_password" name="email_smtp_password" type="password" value="<?= (isset($_POST['email_smtp_password']))? $_POST['email_smtp_password'] : '' ?>">
            </div>
            <div>
                <label for="email_smtp_port"> <?= __('Port')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_smtp_port" name="email_smtp_port" type="number" value="<?= (isset($_POST['email_smtp_port']))? $_POST['email_smtp_port'] : '' ?>">
            </div>
            <div>
                <label for="email_smtp_encryption"> <?= __('Encryption')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_smtp_encryption" name="email_smtp_encryption" type="text" value="<?= (isset($_POST['email_smtp_encryption']))? $_POST['email_smtp_encryption'] : '' ?>">
            </div>
        </fieldset>

        <fieldset id="sendinblue">
            <legend> <?= __('Sendinblue')  ?></legend>
            <div>
                <label for="email_sendinblue_api_key"> <?= __('API Key')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="email_sendinblue_api_key" name="email_sendinblue_api_key" type="text" value="<?= (isset($_POST['email_sendinblue_api_key']))? $_POST['email_sendinblue_api_key'] : '' ?>">
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
                <label for="timezone"> <?= __('Timezone') ?></label>
                <select name="timezone" id="timezone">
                    <option value="Europe/Amsterdam"><?= __('Europe/Amsterdam') ?></option>
                    <option value="Europe/Andorra"><?= __('Europe/Andorra') ?></option>
                    <option value="Europe/Astrakhan"><?= __('Europe/Astrakhan') ?></option>
                    <option value="Europe/Athens"><?= __('Europe/Athens') ?></option>
                    <option value="Europe/Belgrade"><?= __('Europe/Belgrade') ?></option>
                    <option value="Europe/Berlin" selected><?= __('Europe/Berlin') ?></option>
                    <option value="Europe/Bratislava"><?= __('Europe/Bratislava') ?></option>
                    <option value="Europe/Brussels"><?= __('Europe/Brussels') ?></option>
                    <option value="Europe/Bucharest"><?= __('Europe/Bucharest') ?></option>
                    <option value="Europe/Budapest"><?= __('Europe/Budapest') ?></option>
                    <option value="Europe/Busingen"><?= __('Europe/Busingen') ?></option>
                    <option value="Europe/Chisinau"><?= __('Europe/Chisinau') ?></option>
                    <option value="Europe/Copenhagen"><?= __('Europe/Copenhagen') ?></option>
                    <option value="Europe/Dublin"><?= __('Europe/Dublin') ?></option>
                    <option value="Europe/Gibraltar"><?= __('Europe/Gibraltar') ?></option>
                    <option value="Europe/Guernsey"><?= __('Europe/Guernsey') ?></option>
                    <option value="Europe/Helsinki"><?= __('Europe/Helsinki') ?></option>
                    <option value="Europe/Isle_of_Man"><?= __('Europe/Isle_of_Man') ?></option>
                    <option value="Europe/Istanbul"><?= __('Europe/Istanbul') ?></option>
                    <option value="Europe/Jersey"><?= __('Europe/Jersey') ?></option>
                    <option value="Europe/Kaliningrad"><?= __('Europe/Kaliningrad') ?></option>
                    <option value="Europe/Kiev"><?= __('Europe/Kiev') ?></option>
                    <option value="Europe/Kirov"><?= __('Europe/Kirov') ?></option>
                    <option value="Europe/Lisbon"><?= __('Europe/Lisbon') ?></option>
                    <option value="Europe/Ljubljana"><?= __('Europe/Ljubljana') ?></option>
                    <option value="Europe/London"><?= __('Europe/London') ?></option>
                    <option value="Europe/Luxembourg"><?= __('Europe/Luxembourg') ?></option>
                    <option value="Europe/Madrid"><?= __('Europe/Madrid') ?></option>
                    <option value="Europe/Malta"><?= __('Europe/Malta') ?></option>
                    <option value="Europe/Mariehamn"><?= __('Europe/Mariehamn') ?></option>
                    <option value="Europe/Minsk"><?= __('Europe/Minsk') ?></option>
                    <option value="Europe/Monaco"><?= __('Europe/Monaco') ?></option>
                    <option value="Europe/Moscow"><?= __('Europe/Moscow') ?></option>
                    <option value="Europe/Oslo"><?= __('Europe/Oslo') ?></option>
                    <option value="Europe/Paris"><?= __('Europe/Paris') ?></option>
                    <option value="Europe/Podgorica"><?= __('Europe/Podgorica') ?></option>
                    <option value="Europe/Prague"><?= __('Europe/Prague') ?></option>
                    <option value="Europe/Riga"><?= __('Europe/Riga') ?></option>
                    <option value="Europe/Rome"><?= __('Europe/Rome') ?></option>
                    <option value="Europe/Samara"><?= __('Europe/Samara') ?></option>
                    <option value="Europe/San_Marino"><?= __('Europe/San_Marino') ?></option>
                    <option value="Europe/Sarajevo"><?= __('Europe/Sarajevo') ?></option>
                    <option value="Europe/Saratov"><?= __('Europe/Saratov') ?></option>
                    <option value="Europe/Simferopol"><?= __('Europe/Simferopol') ?></option>
                    <option value="Europe/Skopje"><?= __('Europe/Skopje') ?></option>
                    <option value="Europe/Sofia"><?= __('Europe/Sofia') ?></option>
                    <option value="Europe/Stockholm"><?= __('Europe/Stockholm') ?></option>
                    <option value="Europe/Tallinn"><?= __('Europe/Tallinn') ?></option>
                    <option value="Europe/Tirane"><?= __('Europe/Tirane') ?></option>
                    <option value="Europe/Ulyanovsk"><?= __('Europe/Ulyanovsk') ?></option>
                    <option value="Europe/Uzhgorod"><?= __('Europe/Uzhgorod') ?></option>
                    <option value="Europe/Vaduz"><?= __('Europe/Vaduz') ?></option>
                    <option value="Europe/Vatican"><?= __('Europe/Vatican') ?></option>
                    <option value="Europe/Vienna"><?= __('Europe/Vienna') ?></option>
                    <option value="Europe/Vilnius"><?= __('Europe/Vilnius') ?></option>
                    <option value="Europe/Volgograd"><?= __('Europe/Volgograd') ?></option>
                    <option value="Europe/Warsaw"><?= __('Europe/Warsaw') ?></option>
                    <option value="Europe/Zagreb"><?= __('Europe/Zagreb') ?></option>
                    <option value="Europe/Zaporozhye"><?= __('Europe/Zaporozhye') ?></option>
                    <option value="Europe/Zurich"><?= __('Europe/Zurich') ?></option>
                </select>
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
                <label for="congregation_name"> <?= __('Congregation')  ?> <small>(<?= __('Required')  ?>)</small></label>
                <input id="congregation_name" name="congregation_name" required placeholder="<?= __('Example Congregation')  ?>" value="<?= (isset($_POST['congregation_name']))? $_POST['congregation_name'] : '';?>">
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

    var sendinblue = document.getElementById('sendinblue');
    var smtp = document.getElementById('smtp');
    sendinblue.style.display = 'none';
    smtp.style.display = 'none';

    function selectEmailMethod(method) {

        if (method.value === 'smtp') {
            sendinblue.style.display = 'none';
            smtp.style.display = 'block';
            return;
        }
        
        if (method.value === 'sendinblue'){
            sendinblue.style.display = 'block';
            smtp.style.display = 'none';
            return;
        }
        
        sendinblue.style.display = 'none';
        smtp.style.display = 'none';
    }
</script>