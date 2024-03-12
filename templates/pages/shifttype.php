<?php $parse_text_to_html = include '../templates/helpers/parse_text_to_html.php' ?>

<header>
    <h2><?= __('Shift Type List') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./add-shift-type" class="button active">
        <i class="fa fa-plus"></i> <?= __('New Shift Type') ?>
    </a>
</nav>
<div class="table-container">
    <table>
        <tr>
            <th><?= __('Name') ?></th>
            <th><?= __('Max. Publishers per Shift') ?></th>
            <th><?= __('Info') ?></th>
            <th><?= __('Action') ?></th>
        </tr>
        <?php foreach ($placeholder['shift_type_list'] as $shift_type) : ?>
            <tr>
                <td><?= $shift_type['name'] ?></td>
                <td><?= $shift_type['user_per_shift_max'] ?></td>
                <td><?= $parse_text_to_html($shift_type['info']); ?></td>
                <td><a class="button" href="./edit-shift-type?id_shift_type=<?= (int)$shift_type['id_shift_type']; ?>"><i class="fa fa-pencil fa-6"></i> <?= __('Edit') ?></a></td>
            </tr>
        <?php endforeach ?>
    </table>
</div>