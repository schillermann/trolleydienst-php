<?php if (isset($placeholder['message'])) : ?>
	<div id="note-box" class="fade-in">
		<?php if (isset($placeholder['message']['error'])): ?>
			<p class="error">
				<?php echo $placeholder['message']['error'];?>
			</p>
		<?php elseif (isset($placeholder['message']['success'])): ?>
			<p class="success">
				<?php echo $placeholder['message']['success'];?>
			</p>
		<?php endif; ?>
		<button type="button" onclick="closeNoteBox()">
			<i class="fa fa-times"></i> schliessen
		</button>
	</div>
<?php endif; ?>