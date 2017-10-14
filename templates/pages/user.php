<header>
    <h2>Teilnehmer Liste</h2>
</header>
<form method="post">
    <div class="from-button">
        <a href="user-add.php" tabindex="1" class="button active">
            <i class="fa fa-plus" aria-hidden="true"></i> Neuer Teilnehmer
        </a>
        <input placeholder="Teilnehmer suchen" tabindex="2">
        <button type="submit" name="user_search" tabindex="3">
            <i class="fa fa-search" aria-hidden="true"></i>
        </button>
    </div>
</form>
<div class="table-container">
    <table>
        <tr>
            <th>Name</th>
            <th>E-Mail</th>
            <th>Aktiv</th>
            <th>Admin</th>
            <th>Letzter Login</th>
            <th>Aktion</th>
        </tr>
        <?php foreach ($placeholder['user_list'] as $user) : ?>
        <tr>
            <td><?php echo $user['name'];?></td>
            <td><?php echo $user['email'];?></td>
            <td><i class="fa <?php echo ($user['is_active']) ? 'fa-check' : 'fa-times';?>" aria-hidden="true"></i></td>
            <td><i class="fa <?php echo ($user['is_admin']) ? 'fa-check' : 'fa-times';?>" aria-hidden="true"></i></td>
            <td><?php echo $user['last_login'];?></td>
            <td><a class="button" href="user-edit.php?id_user=<?php echo $user['id_user'];?>"><i class="fa fa-pencil" aria-hidden="true"></i> bearbeiten</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>