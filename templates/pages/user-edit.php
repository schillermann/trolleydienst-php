<?php include 'templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Teilnehmer bearbeiten</h2>
</header>
<nav id="nav-sub">
    <a href="user.php" tabindex="16" class="button">
        <i class="fa fa-chevron-left"></i> zurück
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>Teilnehmer</legend>
            <div>
                <label for="is_active">Aktiv</label>
                <input id="is_active" type="checkbox" name="is_active" tabindex="1" <?php if ($placeholder['user']['is_active']):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="is_admin">Admin-Rechte</label>
                <input id="is_admin" type="checkbox" name="is_admin" tabindex="2" <?php if ($placeholder['user']['is_admin']):?>checked<?php endif;?>>
            </div>
            <div>
                <label for="name">Name <small>(Pflichtfeld)</small></label>
                <input id="name" name="name" tabindex="3" required value="<?php echo $placeholder['user']['name'];?>">
            </div>
            <div>
                <label for="email">E-Mail <small>(Pflichtfeld)</small></label>
                <input id="email" name="email" tabindex="4" required value="<?php echo $placeholder['user']['email'];?>">
            </div>
            <div>
                <label for="mobile">Handynr</label>
                <input id="mobile" name="mobile" tabindex="5" value="<?php echo $placeholder['user']['mobile'];?>">
            </div>
            <div>
                <label for="phone">Telefonnr</label>
                <input id="phone" name="phone" tabindex="6" value="<?php echo $placeholder['user']['phone'];?>">
            </div>
            <div>
                <label for="congregation_name">Versammlung</label>
                <input id="congregation_name" name="congregation_name" tabindex="7" value="<?php echo $placeholder['user']['congregation_name'];?>">
            </div>
            <div>
                <label for="language">Sprache</label>
                <input id="language" name="language" tabindex="8" value="<?php echo $placeholder['user']['language'];?>">
            </div>
            <div>
                <label for="note_admin">Admin Bemerkung</label>
                <textarea id="note_admin" name="note_admin" class="note" tabindex="9"><?php echo $placeholder['user']['note_admin'];?></textarea>
            </div>
            <div>
                <label for="note_user">Teilnehmer Bemerkung</label>
                <textarea id="note_user" name="note_user" class="note" tabindex="10" disabled><?php echo $placeholder['user']['note_user'];?></textarea>
            </div>
        </fieldset>
        <div class="from-button">
            <button name="save" class="active" tabindex="11">
                <i class="fa fa-floppy-o"></i> speichern
            </button>
            <button name="delete" class="warning" tabindex="12">
                <i class="fa fa-trash-o"></i> löschen
            </button>
        </div>
    </form>
    <form method="post">
        <fieldset>
            <legend>Passwort</legend>
            <div>
                <label for="password">Neues Passwort</label>
                <input id="password" type="password" name="password" tabindex="13">
            </div>
            <div>
                <label for="password_repeat">Neues Passwort (wiederholen)</label>
                <input id="password_repeat" type="password" name="password_repeat" tabindex="14">
            </div>

        </fieldset>
        <div class="from-button">
            <button name="password_save" class="active" tabindex="15">
                <i class="fa fa-floppy-o"></i> Passwort ändern
            </button>
        </div>
    </form>
    <div id="footnote">
        <p><strong>Geändert am:</strong> <?php echo $placeholder['user']['updated'];?> - <strong>Erstellt am:</strong> <?php echo $placeholder['user']['created'];?></p>
    </div>
</div>