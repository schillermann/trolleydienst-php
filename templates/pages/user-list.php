<header>
    <h2>Teilnehmer Liste</h2>
</header>
<form method="post">
    <div class="from-button">
        <a href="./user-add.php" class="button active">
            <i class="fa fa-plus"></i> Neuer Teilnehmer
        </a>
        <input placeholder="Teilnehmer suchen">
        <button type="submit" name="user_search">
            <i class="fa fa-search"></i>
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
        <?php foreach ($params['userPool']->all() as $user) : ?>
        <tr>
            <td><?= $user->name() ?></td>
            <td><?= $user->email() ?></td>
            <td><i class="fa <?= ($user->active()) ? 'fa-check' : 'fa-times';?>"></i></td>
            <td><i class="fa <?= ($user->administrative()) ? 'fa-check' : 'fa-times';?>"></i></td>
            <td><?= $user->loginAt()->format('Y-m-d H:i') ?></td>
            <td><a class="button" href="./user-edit.php?id_user=<?= $user->id() ?>"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>