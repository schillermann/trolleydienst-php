<header>
    <h2><?= $placeholder['shift_type']['name']; ?> <?= __('Shifts') ?></h2>
    <?php if (!empty($placeholder['shift_type']['info'])) : ?>
        <div class="info-box">
            <p>
                <?= $placeholder['shift_type']['info']; ?>
            </p>
        </div>
    <?php endif; ?>
</header>

<?php if ($_SESSION['is_admin']) : ?>
    <nav id="nav_shift">
        <a href="./shift-add.php?id_shift_type=<?= $placeholder['id_shift_type'] ?>" class="button active">
            <i class="fa fa-plus"></i> <?= __('New Shifts') ?>
        </a>
        <details id="filter_shift">
            <summary><?= __('Show date filter') ?></summary>
            <form method="post">
                <label for="filter_shift_date_from"><?= __('Start Date');
                                                    echo (' ') ?><?= __('from:'); ?></label>
                <input id="filter_shift_date_from" name="filter_shift_date_from" type="date" value="<?= $placeholder['filter_shift_date_from']; ?>">
                <label for="filter_shift_date_to"><?= __('to:') ?></label>
                <input id="filter_shift_date_to" name="filter_shift_date_to" type="date" value="<?= $placeholder['filter_shift_date_to']; ?>">
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
                    <th colspan="2" style="background-color: <?= $shift_list['color_hex']; ?>">
                        <?= $shift_list['day'] ?>,
                        <?= $shift_list['date'] ?> -
                        <?= $shift_list['route'] ?>
                    </th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="2" style="background-color: <?= $shift_list['color_hex']; ?>">
                        <p>
                            <?php if ($_SESSION['is_admin']) : ?>
                                <a href="./shift-edit.php?id_shift_type=<?= $placeholder['id_shift_type'] ?>&id_shift=<?= $id_shift; ?>" class="button">
                                    <i class="fa fa-pencil"></i> <?= __('Edit') ?>
                                </a>
                            <?php endif ?>
                        </p>
                    </td>
                </tr>
            </tfoot>
            <?php $empty_apply_form = false; ?>
            <?php $position = 0 ?>
            <tbody>
                <?php foreach ($shift_list['shifts'] as $shift_time => $user_list) : ?>
                    <?php $position++ ?>
                    <?php $free_places = (int)$placeholder['shift_type']['user_per_shift_max'] - count($user_list) ?>
                    <tr>
                        <td class="shift-time">
                            <?= $shift_time; ?>
                        </td>
                        <td>
                            <?php foreach ($user_list as $id_user => $name) : ?>
                                <span>
                                    <button class="enable" onclick="showDialog(this)" type="button">
                                        <i class="fa fa-check-circle-o"></i> <?= $name ?>
                                    </button>
                                    <?php include '../templates/pagesnippets/dialog.php' ?>
                                </span>
                            <?php endforeach ?>

                            <?php for ($free_place_counter = 0; $free_place_counter < $free_places; $free_place_counter++) : ?>
                                <?php $empty_apply_form = true; ?>
                                <span>
                                    <button class="button promote" onclick="showDialog(this)" type="button">
                                        <i class="fa fa-hand-o-right"></i> <?= __('Available') ?>
                                    </button>
                                    <?php include '../templates/pagesnippets/dialog.php' ?>
                                </span>
                                <?php $empty_apply_form = false; ?>
                            <?php endfor; ?>

                            <?php if ($_SESSION['is_admin'] && $free_places < 1) : ?>
                                <?php $empty_apply_form = true; ?>
                                <span>
                                    <button class="enable user-plus" name="user-plus" type="button" onclick="showDialog(this)" style="float: right;">
                                        <i class="fa fa-user-plus"></i>
                                    </button>
                                    <?php include '../templates/pagesnippets/dialog.php' ?>
                                </span>
                                <?php $empty_apply_form = false; ?>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endforeach ?>
</div>
<script>
    function submitForm(submitForm) {
        submitForm.closest('form').submit();
    }
    function showDialog(dialog) {
        const form = dialog.closest('span').children[1];
        form.showModal();
    }

    function closeDialog(dialog) {
        const form = dialog.closest('span').children[1];
        form.close();
    }
</script>