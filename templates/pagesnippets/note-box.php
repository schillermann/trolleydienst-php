<?php if (isset($placeholder['message'])) : ?>
	<div class="info-box">
		<?php if (isset($placeholder['message']['success'])) : ?>
			<p class="success">
				<?= $placeholder['message']['success'] ?>
			</p>
		<?php elseif(isset($placeholder['message']['error'])): ?>
			<p class="error">
				<?= $placeholder['message']['error'] ?>
			</p>
		<?php endif ?>
	</div>
<?php endif ?>