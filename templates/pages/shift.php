<template id="shift-table">
    <table>
        <thead>
            <tr>
                <th colspan="2" style="background-color: red">{DAY}, {DATE} - {ROUTE_NAME}</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="background-color: red">
                    <p>
                         <!-- if admin -->
                        <a href="./shift-edit.php?id_shift_type=1&id_shift=1" class="button">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                    </p>
                </td>
            </tr>
        </tfoot>
    </table>
</template>

<template id="shift-row">
    <tr>
        <td class="shift-time">08:00 - 10:00</td>
        <td class="shift-publishers"></td>
    </tr>
</template>

<template id="publisher-button">
    <span>
        <button class="enable" onclick="d()" type="button">
            <i class="fa fa-check-circle-o"></i> {FIRSTNAME} {LASTNAME}
        </button>
    </span>
</template>

<template id="apply-button">
    <span>
        <button class="button promote" onclick="openShiftApplyDialog(this)" type="button">
            <i class="fa fa-hand-o-right"></i> <?= __('Available') ?>
        </button>
        
    </span>
</template>

<template id="addition-publisher-button">
    <span>
        <button class="enable user-plus" name="user-plus" type="button" onclick="showDialog(this)" style="float: right;">
            <i class="fa fa-user-plus"></i>
        </button>
    </span>
</template>

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
        <a href="./add-shift?id_shift_type=<?= $placeholder['id_shift_type'] ?>" class="button active">
            <i class="fa fa-plus"></i> <?= __('New Shifts') ?>
        </a>
    </nav>
<?php endif ?>
<?php include '../templates/pagesnippets/note-box.php' ?>

<dialog id="shift-apply-dialog">
    <header>
        <h2><?= __('Apply') ?></h2>
    </header>
    <div>
        <img src="images/gadgets.svg">
    </div>
    <div>
        <select name="publishers" style="width: 100%">
            <option value=""><?= __('Choose publisher') ?></option>
            <?php foreach ($placeholder['user_promote_list'] as $id_user => $name) : ?>
                <option value="<?= $id_user ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select>
        <button class="button" id="shift-apply-button" onclick="applyShift(this)" style="width: 100%"><?= __('Apply') ?></button>
        <button class="button" style="width: 100%" onclick="f()"><?= __('Cancel') ?></button>
    </div>
</dialog>
<script src="./js/shift-apply-dialog.js"></script>

<div class="table-container"></div>
<div class="number-of-pages">
    <p style="text-align: center"></p>
</div>
<div class="loading">
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
</div>

<script type="module" src="./js/list-shifts.js"></script>