<?php $parse_text_to_html = include 'templates/helpers/parse_text_to_html.php'; ?>

<header>
    <h2>Schichttyp Liste</h2>
</header>
<nav id="nav-sub">
    <a href="shifttype-add.php" tabindex="1" class="button active">
        <i class="fa fa-plus"></i> Neuer Schichttyp
    </a>
</nav>
<div class="table-container">
    <table>
        <tr>
            <th>Name</th>
            <th>Teilnehmer pro Schicht maximal</th>
            <th>Info</th>
            <th>Aktion</th>
        </tr>
        <?php foreach ($placeholder['shift_type_list'] as $shift_type) : ?>
        <tr>
            <td><?php echo $shift_type['name']; ?></td>
            <td><?php echo $shift_type['user_per_shift_max']; ?></td>
            <td><?php echo $parse_text_to_html($shift_type['info']);?></td>
            <td><a class="button" href="shifttype-edit.php?id_shift_type=<?php echo (int)$shift_type['id_shift_type'];?>"><i class="fa fa-pencil fa-6"></i> bearbeiten</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>