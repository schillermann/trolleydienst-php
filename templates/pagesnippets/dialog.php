<dialog id="promote_shift">
    <!-- form img -->
    <!-- form date und time -->
    <div>
        <div class="promote_shift_row">
            <?php include("./images/shift_dialog_icon.svg"); ?>
        </div>
        <div class="promote_shift_row" id="promote_shift_details">
            <span><?= __('Shift');
                    echo (':') ?></span>
            <span><i class="fa fa-calendar-o"></i><?= $shift_list['day'] ?>, <?= $shift_list['date'] ?></span>
            <span><i class="fa fa-clock-o"></i><?= $shift_time;
                                                echo (' ' . __('Clock')) ?></span>
        </div>

        <!-- form contact (if) $empty_apply_form ist not empty -->
        <?php if (!$empty_apply_form) : ?>
            <div class="promote_shift_row" id="promote_shift_contact">
                <p><?= __('Get in touch with');
                    echo (' ') ?>
                    <span>
                        <a href="./user-details.php?id_shift_type=<?= (int)$_GET['id_shift_type']; ?>&id_user=<?= $id_user ?>"><?= $name ?></a><i class="fa fa-external-link"></i></span>
                </p>
            </div>
        <?php endif ?>

        <!-- form zum bewerben -> Button wird nur bei VK angezeigt -->
        <div class="promote_shift_row" id="promote_shift_button">
            <?php if ($empty_apply_form && !$_SESSION['is_admin']) : ?>
                <form method="post">
                    <input type="hidden" name="position" value="<?= $position ?>">
                    <input type="hidden" name="id_shift" value="<?= $id_shift ?>">
                    <input type="hidden" name="promote_id_user" value="<?= $_SESSION['id_user'] ?>">

                    <button data-status="apply"><i class="fa fa-check-circle-o"></i> <?= __('Apply') ?></button>
                </form>
            <?php endif ?>

            <!-- form VK löschen wir angezeigt, wenn es DER Vk ist oder Admin -->
            <?php $has_user_promoted =  @$id_user === $_SESSION['id_user']; ?>
            <?php if (!$empty_apply_form && ($has_user_promoted || $_SESSION['is_admin'])) : ?>
                <form method="post">
                    <input type="hidden" name="position" value="<?= $position ?>">
                    <input type="hidden" name="id_shift" value="<?= $id_shift ?>">
                    <input type="hidden" name="cancel_id_user" value="<?= $id_user ?>">
                    <button data-status="delete"><i class="fa fa-trash-o"> </i> <?= __('Delete') ?></button>
                </form>
            <?php endif ?>

            <?php if ($empty_apply_form && $_SESSION['is_admin']) : ?>
                <?php $has_id_user = $id_user; ?>
                <form method="post">
                    <input type="hidden" name="position" value="<?= $position ?>">
                    <input type="hidden" name="id_shift" value="<?= $id_shift ?>">
                    <select name="promote_id_user" class="button promote" onchange="submitForm(this)">
                        <option value="0"><?= __('Available') ?></option>
                        <?php foreach ($placeholder['user_promote_list'] as $id_user => $name) : ?>
                            <option value="<?= $id_user ?>"><?= $name ?></option>
                        <?php endforeach;
                        ?>
                    </select>
                </form>
            <?php endif ?>

            <button data-status="close" onclick="closeDialog(this)"><i class="fa fa-times-circle"></i> <?= __('Close') ?></button>
        </div>

    </div>

</dialog>