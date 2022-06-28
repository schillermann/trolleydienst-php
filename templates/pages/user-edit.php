<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Teilnehmer bearbeiten</h2>
</header>
<nav id="nav-sub">
    <a href="./user.php" class="button">
        <i class="fa fa-chevron-left"></i> zurück
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Teilnehmer</legend>
            <div>
                <label for="is_active">Aktiv</label>
                <input id="is_active" type="checkbox" name="is_active" <?php if ($placeholder['user']['is_active']):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="is_admin">Admin-Rechte</label>
                <input id="is_admin" type="checkbox" name="is_admin" <?php if ($placeholder['user']['is_admin']):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="username">Benutzername <small>(Pflichtfeld)</small></label>
                <input id="username" name="username" required value="<?php echo $placeholder['user']['username'];?>">
            </div>
            <div>
                <label for="name">Name <small>(Pflichtfeld)</small></label>
                <input id="name" name="name" required value="<?php echo $placeholder['user']['name'];?>">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" name="email" required value="<?php echo $placeholder['user']['email'];?>">
            </div>
            <div>
                <label for="mobile">Handynummer</label>
                <input id="mobile" name="mobile" value="<?php echo $placeholder['user']['mobile'];?>">
            </div>
            <div>
                <label for="phone">Telefonnummer</label>
                <input id="phone" name="phone" value="<?php echo $placeholder['user']['phone'];?>">
            </div>
            <div>
                <label for="congregation_name">Versammlung</label>
                <input id="congregation_name" name="congregation_name" value="<?php echo $placeholder['user']['congregation_name'];?>">
            </div>
            <div>
                <label for="language">Sprache</label>
                <input id="language" name="language" value="<?php echo $placeholder['user']['language'];?>">
            </div>
            <div>
                <label for="note_admin">Admin Bemerkung</label>
                <textarea id="note_admin" name="note_admin" class="note"><?php echo $placeholder['user']['note_admin'];?></textarea>
            </div>
            <div>
                <label for="note_user">Teilnehmer Bemerkung</label>
                <textarea id="note_user" name="note_user" class="note" disabled><?php echo $placeholder['user']['note_user'];?></textarea>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active">
                <i class="fa fa-floppy-o"></i> speichern
            </button>
            <button name="delete" class="warning">
                <i class="fa fa-trash-o"></i> löschen
            </button>
        </div>
    </form>
    <form method="post">
        <fieldset>
            <legend>Passwort</legend>
            <div>
                <label for="password">Neues Passwort</label>
                <input id="password" type="password" name="password">
            </div>
            <div>
                <label for="password_repeat">Neues Passwort (wiederholen)</label>
                <input id="password_repeat" type="password" name="password_repeat">
            </div>

        </fieldset>
        <div class="from-button">
            <button name="password_save" class="active">
                <i class="fa fa-floppy-o"></i> Passwort ändern
            </button>
        </div>
    </form>
    <div id="footnote">
        <p><strong>Geändert am:</strong> <?php echo $placeholder['user']['updated'];?> - <strong>Erstellt am:</strong> <?php echo $placeholder['user']['created'];?></p>
    </div>
</div>