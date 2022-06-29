<header>
    <h2><?php echo __("Teilnehmer Liste"); ?></h2>
</header>
<form method="post">
    <div class="from-button">
        <a href="./user-add.php" class="button active">
            <i class="fa fa-plus"></i> <?php echo __("Neuer Teilnehmer"); ?>
        </a>
        <input placeholder="<?php echo __("Teilnehmer suchen"); ?>">
        <button type="submit" name="user_search">
            <i class="fa fa-search"></i>
        </button>
    </div>
</form>
<div class="table-container">
    <table>
        <tr>
            <th><?php echo __("Name"); ?></th>
            <th><?php echo __("E-Mail"); ?></th>
            <th><?php echo __("Aktiv"); ?></th>
            <th><?php echo __("Admin"); ?></th>
            <th><?php echo __("Letzter Login"); ?></th>
            <th><?php echo __("Aktion"); ?></th>
        </tr>
        <?php foreach ($placeholder['user_list'] as $user) : ?>
        <tr>
            <td><?php echo $user['name'];?></td>
            <td><?php echo $user['email'];?></td>
            <td><i class="fa <?php echo ($user['is_active']) ? 'fa-check' : 'fa-times';?>"></i></td>
            <td><i class="fa <?php echo ($user['is_admin']) ? 'fa-check' : 'fa-times';?>"></i></td>
            <td><?php echo $user['last_login'];?></td>
            <td><a class="button" href="./user-edit.php?id_user=<?php echo $user['id_user'];?>"><i class="fa fa-pencil"></i> <?php echo __("bearbeiten"); ?></a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>