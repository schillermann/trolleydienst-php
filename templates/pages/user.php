<header>
    <h2><?= __('Publisher List') ?></h2>
</header>
<form method="post">
    <div class="from-button">
        <a href="./user-add.php" class="button active">
            <i class="fa fa-plus"></i> <?= __('New Pubisher') ?>
        </a>
        <input placeholder="<?= __('Search Publishers') ?>" name="user_search">
        <button type="submit">
            <i class="fa fa-search"></i>
        </button>
    </div>
</form>
<div class="table-container">
    <table>
        <tr>
            <th><?= __('First Name') ?></th>
            <th><?= __('Last Name') ?></th>
            <th><?= __('Email') ?></th>
            <th><?= __('Active') ?></th>
            <th><?= __('Admin') ?></th>
            <th><?= __('Last Login') ?></th>
            <th><?= __('Action') ?></th>
        </tr>
        <?php foreach ($placeholder['user_list'] as $user) : ?>
            <tr>
                <td><?= $user['first_name']; ?></td>
                <td><?= $user['last_name']; ?></td>
                <td><?= $user['email']; ?></td>
                <td><i class="fa <?= ($user['active']) ? 'fa-check' : 'fa-times'; ?>"></i></td>
                <td><i class="fa <?= ($user['administrative']) ? 'fa-check' : 'fa-times'; ?>"></i></td>
                <td><?= $user['logged_on']; ?></td>
                <td><a class="button" href="./user-edit.php?id_user=<?= $user['id']; ?>"><i class="fa fa-pencil"></i> <?= __('Edit') ?></a></td>
            </tr>
        <?php endforeach ?>
    </table>
</div>