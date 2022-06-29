<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?php echo __("Profil"); ?></h2>
</header>
<nav id="nav-sub">
    <a href="./profile.php" class="button">
        <i class="fa fa-user"></i> <?php echo __("Benutzerdaten"); ?>
    </a>
    <a href="./profile-password.php" class="button active">
        <i class="fa fa-lock"></i> <?php echo __("Passwort"); ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?php echo __("Passwort"); ?></legend>
            <div>
                <label for="password"><?php echo __("Neues Passwort"); ?></label>
                <input id="password" type="password" name="password">
            </div>
            <div>
                <label for="password_repeat"><?php echo __("Neues Passwort"); ?> (<?php echo __("wiederholen"); ?>)</label>
                <input id="password_repeat" type="password" name="password_repeat">
            </div>

        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?php echo __("Passwort ändern"); ?>
            </button>
        </div>
    </form>
</div>