<?php if (isset($placeholder['message'])) : ?>
    <div id="note-box" class="fade-in">
		<?php if (isset($placeholder['message']['success'])): ?>
            <p class="success">
				<?php echo $placeholder['message']['success']; ?>
            </p>
            <div id="note-box-content">
                <table>
					<?php foreach ($placeholder['user_list'] as $user): ?>
                        <tr>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                        </tr>
					<?php endforeach; ?>
                </table>
            </div>
		<?php else: ?>
            <p class="error">
				<?php echo $placeholder['message']['error']; ?>
            </p>
		<?php endif;?>
        <button type="button" onclick="closeNoteBox()">
            <i class="fa fa-times"></i> schliessen
        </button>
    </div>
<?php endif;?>

<header>
    <h2>E-Mail Versand</h2>
</header>
<nav id="nav-sub">
    <a href="email-settings.php" class="button">
        <i class="fa fa-cog"></i> Einstellungen
    </a>
    <a href="email-templates.php?id_email_template=1" class="button">
        <i class="fa fa-cog"></i> Vorlagen
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <fieldset>
            <legend>An alle Teilnehmer</legend>
            <div>
                <label for="email_subject">Betreff <small>(Pflichtfeld)</small></label>
                <input id="email_subject" name="email_subject" class="email-subject" required value="<?php echo $placeholder['email']['subject']; ?>">
            </div>
            <div>
                <label for=email_"message">Text <small>(Pflichtfeld)</small></label>
                <textarea id="email_message" name="email_message" rows="20" required><?php echo $placeholder['email']['message'];?></textarea>
            </div>

        </fieldset>
        <div class="from-button">
            <button name="send" class="active">
                <i class="fa fa-paper-plane"></i> Senden
            </button>
        </div>
</form>
</div>
