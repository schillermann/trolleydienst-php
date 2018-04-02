<?php include 'templates/pagesnippets/note-box.php' ?>
<header>
	<h2>E-Mail Vorlagen</h2>
</header>
<nav id="nav-sub">
	<a href="email.php" class="button">
		<i class="fa fa-chevron-left"></i> zurück
	</a>
	<?php foreach ($placeholder['email_templates'] as $template): ?>
		<a href="email-templates.php?id_email_template=<?php echo $template['id_email_template'];?>" class="button <?php echo ($placeholder['id_email_template'] == $template['id_email_template'])? 'active': '';?>">
			<?php echo $template['subject'];?>
		</a>
	<?php endforeach;?>
</nav>
<div class="container-center">
	<form method="post">
		<fieldset>
			<legend>E-Mail Vorlage: <?php echo $placeholder['selected_template']['subject'];?></legend>
			<div>
				<label for="template_email_subject">Betreff <small>(Pflichtfeld)</small></label>
				<input id="template_email_subject" name="template_email_subject" class="email-subject" required value="<?php echo $placeholder['selected_template']['subject']; ?>">
			</div>
			<div>
				<label for="template_email_message">Nachricht <small>(Pflichtfeld)</small></label>
				<textarea id="template_email_message" name="template_email_message" rows="20" required><?php echo $placeholder['selected_template']['message'];?></textarea>
			</div>
			<div>
				<p><strong>Geändert am:</strong> <?php echo $placeholder['selected_template']['updated'];?></p>
			</div>
		</fieldset>
		<div class="from-button">
			<button name="save" class="active">
				<i class="fa fa-floppy-o"></i> speichern
			</button>
		</div>
	</form>
</div>
