<?php include 'templates/pagesnippets/note-box.php' ?>
<header>
    <h2>Bericht abgeben</h2>
</header>
<nav>
    <a href="report.php" tabindex="15" class="button">
        <i class="fa fa-chevron-left"></i> zurück
    </a>
</nav>
<div class="container-center">
	<?php $selected_user_id = (empty($_POST)) ? $_SESSION['id_user'] : (int)$_POST['id_user']; ?>
	<form method="post">
		<fieldset>
			<legend>Bericht abgeben</legend>
			<div>
				<label for="id_user">Name</label>
				<select id="id_user" name="id_user" tabindex="1">
					<?php foreach($placeholder['user_list'] as $user): ?>
						<option value="<?php echo $user['id_user'];?>" <?php echo ((int)$user['id_user'] === $selected_user_id)? 'selected':'';?>>
							<?php echo $user['name'];?>
						</option>
					<?php endforeach;?>
				</select>
			</div>
            <div>
                <label for="route">Route</label>
                <select id="route" name="route" tabindex="2">
					<?php foreach($placeholder['route_list'] as $route): ?>
                        <option value="<?php echo $route['route'];?>">
							<?php echo $route['route'];?>
                        </option>
					<?php endforeach;?>
                </select>
            </div>
            <div>
                <label for="id_shift_type">Schichtart</label>
                <select id="id_shift_type" name="id_shift_type" tabindex="3">
					<?php foreach($placeholder['shifttype_list'] as $shifttype): ?>
                        <option value="<?php echo $shifttype['id_shift_type'];?>" <?php echo (isset($_POST['id_shift_type']) && $_POST['id_shift_type'] == $shifttype['id_shift_type'])? 'selected':'';?>>
							<?php echo $shifttype['name'];?>
                        </option>
					<?php endforeach;?>
                </select>
            </div>
			<div>
				<label for="date_from">Schichtzeit Datum <small>(Pflichtfeld)</small></label>
				<input id="date_from" type="date" name="date_from" tabindex="4" required value="<?php echo (isset($_POST['date_from']))? $_POST['date_from'] : '';?>">
			</div>
			<div>
				<label for="time_from">Schichtzeit Beginn <small>(Pflichtfeld)</small></label>
				<input id="time_from" type="time" name="time_from" tabindex="5" required value="<?php echo (isset($_POST['time_from']))? $_POST['time_from'] : '';?>">
			</div>
			<div>
				<label for="book">Bücher <small>(Pflichtfeld)</small></label>
				<input id="book" type="number" name="book" tabindex="6" value="<?php echo (isset($_POST['book']))? (int)$_POST['book'] : 0;?>">
			</div>
			<div>
				<label for="brochure">Broschüren <small>(Pflichtfeld)</small></label>
				<input id="brochure" type="number" name="brochure" tabindex="7" value="<?php echo (isset($_POST['brochure']))? (int)$_POST['brochure'] : 0;?>">
			</div>
			<div>
				<label for="bible">Bibeln <small>(Pflichtfeld)</small></label>
				<input id="bible" type="number" name="bible" tabindex="8" value="<?php echo (isset($_POST['bible']))? (int)$_POST['bible'] : 0;?>">
			</div>
			<div>
				<label for="magazine">Zeitschriften <small>(Pflichtfeld)</small></label>
				<input id="magazine" type="number" name="magazine" tabindex="9" value="<?php echo (isset($_POST['magazine']))? (int)$_POST['magazine'] : 0;?>">
			</div>
			<div>
				<label for="tract">Traktate <small>(Pflichtfeld)</small></label>
				<input id="tract" type="number" name="tract" tabindex="10" value="<?php echo (isset($_POST['tract']))? (int)$_POST['tract'] : 0;?>">
			</div>
			<div>
				<label for="address">Adressen <small>(Pflichtfeld)</small></label>
				<input id="address" type="number" name="address" tabindex="11" value="<?php echo (isset($_POST['address']))? (int)$_POST['address'] : 0;?>">
			</div>
			<div>
				<label for="talk">Gespräche <small>(Pflichtfeld)</small></label>
				<input id="talk" type="number" name="talk" tabindex="12" value="<?php echo (isset($_POST['talk']))? (int)$_POST['talk'] : 0;?>">
			</div>
			<div>
				<label for="note_user">Bemerkung</label>
				<textarea id="note_user" name="note_user" class="note" tabindex="13"><?php echo (isset($_POST['note_user']))? $_POST['note_user'] : '';?></textarea>
			</div>
		</fieldset>
		<div class="from-button">
			<button name="save" class="active" tabindex="14">
				<i class="fa fa-floppy-o"></i> speichern
			</button>
		</div>
	</form>
</div>