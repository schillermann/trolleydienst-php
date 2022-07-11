<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?= __('Submit Report') ?></h2>
</header>
<nav>
    <a href="./report.php" class="button">
        <i class="fa fa-chevron-left"></i> <?= __('Back') ?>
    </a>
</nav>
<div class="container-center">
	<?php $selected_user_id = (empty($_POST)) ? $_SESSION['id_user'] : (int)$_POST['id_user'] ?>
	<form method="post">
		<fieldset>
			<legend><?= __('Submit Report') ?></legend>
			<div>
				<label for="id_user"><?= __('Name') ?></label>
				<select id="id_user" name="id_user">
					<?php foreach($placeholder['user_list'] as $user): ?>
						<option value="<?= $user['id'];?>" <?= ((int)$user['id'] === $selected_user_id)? 'selected':'';?>>
							<?= $user['first_name'] . ' ' . $user['last_name'] ?>
						</option>
					<?php endforeach;?>
				</select>
			</div>
            <div>
                <label for="route"><?= __('Location') ?></label>
                <select id="route" name="route">
					<?php foreach($placeholder['route_list'] as $route): ?>
                        <option value="<?= $route['route'];?>">
							<?= $route['route'];?>
                        </option>
					<?php endforeach;?>
                </select>
            </div>
            <div>
                <label for="id_shift_type"><?= __('Shift Type') ?></label>
                <select id="id_shift_type" name="id_shift_type">
					<?php foreach($placeholder['shifttype_list'] as $shifttype): ?>
                        <option value="<?= $shifttype['id_shift_type'];?>" <?= (isset($_POST['id_shift_type']) && $_POST['id_shift_type'] == $shifttype['id_shift_type'])? 'selected':'';?>>
							<?= $shifttype['name'];?>
                        </option>
					<?php endforeach;?>
                </select>
            </div>
			<div>
				<label for="date_from"><?= __('Start Date') ?> <small>(<?= __('Required') ?>)</small></label>
				<input id="date_from" type="date" name="date_from" required value="<?= (isset($_POST['date_from']))? $_POST['date_from'] : '';?>">
			</div>
			<div>
				<label for="time_from"><?= __('Start Time') ?> <small>(<?= __('Required') ?>)</small></label>
				<input id="time_from" type="time" name="time_from" required value="<?= (isset($_POST['time_from']))? $_POST['time_from'] : '';?>">
			</div>
			<div>
				<label for="book"><?= __('Books') ?> <small>(<?= __('Required') ?>)</small></label>
				<input id="book" type="number" name="book" value="<?= (isset($_POST['book']))? (int)$_POST['book'] : 0;?>">
			</div>
			<div>
				<label for="brochure"><?= __('Brochures') ?> <small>(<?= __('Required') ?>)</small></label>
				<input id="brochure" type="number" name="brochure" value="<?= (isset($_POST['brochure']))? (int)$_POST['brochure'] : 0;?>">
			</div>
			<div>
				<label for="bible"><?= __('Bibles') ?> <small>(<?= __('Required') ?>)</small></label>
				<input id="bible" type="number" name="bible" value="<?= (isset($_POST['bible']))? (int)$_POST['bible'] : 0;?>">
			</div>
			<div>
				<label for="magazine"><?= __('Magazines') ?> <small>(<?= __('Required') ?>)</small></label>
				<input id="magazine" type="number" name="magazine" value="<?= (isset($_POST['magazine']))? (int)$_POST['magazine'] : 0;?>">
			</div>
			<div>
				<label for="tract"><?= __('Tracts') ?> <small>(<?= __('Required') ?>)</small></label>
				<input id="tract" type="number" name="tract" value="<?= (isset($_POST['tract']))? (int)$_POST['tract'] : 0;?>">
			</div>
			<div>
				<label for="address"><?= __('Addresses') ?> <small>(<?= __('Required') ?>)</small></label>
				<input id="address" type="number" name="address" value="<?= (isset($_POST['address']))? (int)$_POST['address'] : 0;?>">
			</div>
			<div>
				<label for="talk"><?= __('Conversations') ?> <small>(<?= __('Required') ?>)</small></label>
				<input id="talk" type="number" name="talk" value="<?= (isset($_POST['talk']))? (int)$_POST['talk'] : 0;?>">
			</div>
			<div>
				<label for="note_user"><?= __('Notes') ?></label>
				<textarea id="note_user" name="note_user" class="note"><?= (isset($_POST['note_user']))? $_POST['note_user'] : '';?></textarea>
			</div>
		</fieldset>
		<div class="from-button">
			<button name="save" class="active">
				<i class="fa fa-floppy-o"></i> <?= __('Save') ?>
			</button>
		</div>
	</form>
</div>