<header>
    <h2><?= $placeholder['shift_type']['name'];?> <?= __('Shifts') ?></h2>
    <?php if(!empty($placeholder['shift_type']['info'])): ?>
        <div class="info-box">
            <p>
                <?= $placeholder['shift_type']['info'];?>
            </p>
        </div>
    <?php endif;?>
</header>

<?php if($_SESSION['is_admin']): ?>
    <nav id="nav_shift">
        <a href="./shift-add.php?id_shift_type=<?= $placeholder['id_shift_type']?>" class="button active">
            <i class="fa fa-plus"></i> <?= __('New Shifts') ?>
        </a>
        <details id="filter_shift">
        <summary><?= __('Show date filter') ?></summary>
            <form method="post">
                <label for="filter_shift_date_from"><?= __('Start Date'); echo(' ')?><?= __('from:'); ?></label>
                <input id="filter_shift_date_from" name="filter_shift_date_from" type="date" value="<?= $placeholder['filter_shift_date_from'];?>">
                <label for="filter_shift_date_to"><?= __('to:') ?></label>
                <input id="filter_shift_date_to" name="filter_shift_date_to" type="date" value="<?= $placeholder['filter_shift_date_to'];?>">
                <button name="filter_shift" class="active">
                    <i class="fa fa-filter"></i> <?= __('Filter') ?>
                </button>
            </form>
        </details>
    </nav>
<?php endif ?>

<?php include '../templates/pagesnippets/note-box.php' ?>

<div class="table-container">
    <?php foreach ($placeholder['shift_day'] as $id_shift => $shift_list) : ?>
        <table id="id_shift_<?= $id_shift ?>">
            <thead>
            <tr>
                <th colspan="2" style="background-color: <?= $shift_list['color_hex'];?>">
                    <?= $shift_list['day'] ?>,
                    <?= $shift_list['date'] ?> -
                    <?= $shift_list['route'] ?>
                </th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="2" style="background-color: <?= $shift_list['color_hex'];?>">
                    <p>
                        <?php if($_SESSION['is_admin']): ?>
                            <a href="./shift-edit.php?id_shift_type=<?= $placeholder['id_shift_type']?>&id_shift=<?= $id_shift;?>" class="button">
                                <i class="fa fa-pencil"></i> <?= __('Edit') ?>
                            </a>
                        <?php endif ?>
                    </p>
                </td>
            </tr>
            </tfoot>
            <?php $position = 0 ?>
            <tbody>
            <?php foreach ($shift_list['shifts'] as $shift_time => $user_list) : ?>
                <?php $position++ ?>
                <?php $free_places = (int)$placeholder['shift_type']['user_per_shift_max'] - count($user_list) ?>
                <tr>
                    <td class="shift-time">
                        <?= $shift_time;?>
                    </td>
                    <td>
                        <?php foreach ($user_list as $id_user => $name) : ?>
                            <?php $has_user_promoted = $id_user === $_SESSION['id_user'];?>

                            <?php if($has_user_promoted || $_SESSION['is_admin']): ?>
                                <form method="post" class="form_inline">
                                    <input type="hidden" name="position" value="<?= $position ?>">
                                    <input type="hidden" name="id_shift" value="<?= $id_shift ?>">
                                    <input type="hidden" name="cancel_id_user" value="<?= $id_user ?>">
                                    <button class="enable" onclick="submitForm(this)" type="button">
                                        <i class="fa fa-thumbs-o-up"></i> <?= $name ?>
                                    </button>
                                </form>
                            <?php else: ?>
                                <a href="./user-details.php?id_shift_type=<?= (int)$_GET['id_shift_type'];?>&id_user=<?= $id_user ?>" class="button promoted">
                                    <i class="fa fa-info"></i> <?= $name ?>
                                </a>
                            <?php endif ?>
                        <?php endforeach ?>

                        <?php for($free_place_counter = 0; $free_place_counter < $free_places; $free_place_counter++): ?>
                            <form method="post" class="form_inline">
                                <input type="hidden" name="position" value="<?= $position ?>">
                                <input type="hidden" name="id_shift" value="<?= $id_shift ?>">
                                <select name="promote_id_user" class="button promote" onchange="submitForm(this)">
                                <option value="0"><?= __('Apply') ?></option>
                                <?php if($_SESSION['is_admin']) {
                                	foreach ($placeholder['user_promote_list'] as $id_user => $name): ?>
                                    <option value="<?= $id_user ?>"><?= $name ?></option>
                                <?php endforeach;
	                                } else { ?>
                        			<option value="<?= $_SESSION['id_user'] ?>"><?= $_SESSION['name'] ?></option>
								<?php } ?>
                            </select>
                            </form>
                        <?php endfor;?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    <?php endforeach ?>
</div>
<script>
function submitForm(submitForm) {
    var applyButton = submitForm.closest('.button');
    if (submitForm.classList.contains('enable')) {
        if (window.confirm("<?= __("Are you sure you would like to cancel this shift?") ?>")) {
            document.getElementById('loading-screen').style.display = 'block';
            setTimeout(function() { submitForm.form.submit(); }, 200);
        }
    } else {
        if (window.confirm("<?= __("Are you sure you would like to cover this shift?") ?>")) {
            document.getElementById('loading-screen').style.display = 'block';
            setTimeout(function() { submitForm.form.submit(); }, 200);
        } else {
            applyButton.value = 0;
        }
    }
}
</script>