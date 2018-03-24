<select name="id_user" class="button promote" onchange="submitForm(this)">
    <option value="0">bewerben</option>
    <?php foreach ($placeholder['user_promote_list'] as $id_user => $name): ?>
        <option value="<?php echo $id_user; ?>">
            <?php echo $name; ?>
        </option>
    <?php endforeach;?>
</select>