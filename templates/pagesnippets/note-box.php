<?php if (isset($placeholder['message'])) : ?>
	<div id="note-box" class="fade-in">
		<?php if (isset($placeholder['message']['error'])): ?>
			<p class="error">
				<?= $placeholder['message']['error'] ?>
			</p>
		<?php elseif (isset($placeholder['message']['success'])): ?>
			<p class="success">
				<?= $placeholder['message']['success'] ?>
			</p>
		<?php endif; ?>
		<button type="button" onclick="closeNoteBox()">
			<i class="fa fa-times"></i> <?= __('Close') ?>
		</button>
	</div>
<?php endif; ?>