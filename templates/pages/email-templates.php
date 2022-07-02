<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
	<h2><?= __('Email Templates') ?></h2>
</header>
<nav id="nav-sub">
	<a href="./email.php" class="button">
		<i class="fa fa-chevron-left"></i> <?= __('Back') ?>
	</a>
	<?php foreach ($placeholder['email_templates'] as $template): ?>
		<a href="./email-templates.php?id_email_template=<?= $template['id_email_template'];?>" class="button <?= ($placeholder['id_email_template'] == $template['id_email_template'])? 'active': '';?>">
			<?= $template['subject'];?>
		</a>
	<?php endforeach;?>
</nav>
<div class="container-center">
	<form method="post">
		<fieldset>
			<legend><?= __('Email Template') ?>: <?= $placeholder['selected_template']['subject'];?></legend>
			<div>
				<label for="template_email_subject"><?= __('Subject') ?> <small>(<?= __('Required') ?>)</small></label>
				<input id="template_email_subject" name="template_email_subject" class="email-subject" required value="<?= $placeholder['selected_template']['subject'] ?>">
			</div>
			<div>
				<label for="template_email_message"><?= __('Message') ?> <small>(<?= __('Required') ?>)</small></label>
				<textarea id="template_email_message" name="template_email_message" rows="20" required><?= $placeholder['selected_template']['message'];?></textarea>
			</div>
			<div>
				<p><strong><?= __('Updated on') ?>:</strong> <?= $placeholder['selected_template']['updated'];?></p>
			</div>
		</fieldset>
		<div class="from-button">
			<button name="save" class="active">
				<i class="fa fa-floppy-o"></i> <?= __('Save') ?>
			</button>
		</div>
	</form>
</div>
