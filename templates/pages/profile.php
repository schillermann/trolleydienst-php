<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?php echo __("Profil"); ?></h2>
</header>
<nav id="nav-sub">
    <a href="./profile.php" class="button active">
        <i class="fa fa-user"></i> <?php echo __("Benutzerdaten"); ?>
    </a>
    <a href="./profile-password.php" class="button">
        <i class="fa fa-lock"></i> <?php echo __("Passwort"); ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?php echo __("Kontaktdaten"); ?></legend>
            <div>
                <label for="username"><?php echo __("Benutzername"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="username" name="username" required value="<?php echo $placeholder['profile']['username']; ?>">
            </div>
            <div>
                <label for="name"><?php echo __("Name"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="name" name="name" required value="<?php echo $placeholder['profile']['name']; ?>">
            </div>
            <div>
                <label for="email"><?php echo __("E-Mail"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="email" type="email" name="email" required value="<?php echo $placeholder['profile']['email']; ?>">
            </div>
            <div>
                <label for="phone"><?php echo __("Telefon"); ?></label>
                <input id="phone" type="tel" name="phone" value="<?php echo $placeholder['profile']['phone']; ?>">
            </div>
            <div>
                <label for="mobile"><?php echo __("Handy"); ?></label>
                <input id="mobile" type="tel" name="mobile" value="<?php echo $placeholder['profile']['mobile']; ?>">
            </div>
            <div>
                <label for="congregation_name"><?php echo __("Versammlung"); ?></label>
                <input id="congregation_name" name="congregation_name" value="<?php echo $placeholder['profile']['congregation_name']; ?>">
            </div>
            <div>
                <label for="language"><?php echo __("Sprache"); ?></label>
                <input id="language" name="language" value="<?php echo $placeholder['profile']['language']; ?>">
            </div>
            <div>
                <label for="note_user"><?php echo __("Bemerkung"); ?></label>
                <textarea id="note_user" name="note_user" class="note"><?php echo $placeholder['profile']['note_user']; ?></textarea>
            </div>

        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> <?php echo __("Profil speichern"); ?>
            </button>
        </div>
    </form>
</div>