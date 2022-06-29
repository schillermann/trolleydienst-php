<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?php echo __("Passwort vergessen"); ?></h2>
</header>
<nav id="nav-sub">
    <a href="./" class="button">
        <i class="fa fa-chevron-left"></i> <?php echo __("zurück"); ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend><?php echo __("Passwort anfordern"); ?></legend>
            <div>
                <label for="username"><?php echo __("Benutzername"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="username" name="username" required>
            </div>
            <div>
                <label for="email"><?php echo __("E-Mail"); ?> <small>(<?php echo __("Pflichtfeld"); ?>)</small></label>
                <input id="email" type="email" name="email" required>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="password_reset" class="active">
                <i class="fa fa-undo"></i> <?php echo __("Neues Passwort anfordern"); ?>
            </button>
        </div>
    </form>
</div>