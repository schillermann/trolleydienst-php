<header>
    <h2><?= $language->translation('Publisher') ?></h2>
</header>
<form method="get">
    <div class="from-button">
        <a href="user-add" class="button active">
            <i class="fa fa-plus"></i> <?= $language->translation('Create Publisher') ?>
        </a>
        <input name="search" type="search" placeholder="<?= $language->translation('Search Publishers') ?>" value="<?= $searchPattern ?>">
        <button type="submit">
            <i class="fa fa-filter"></i>
        </button>
    </div>
</form>
<div class="table-container">
    <table>
        <tr>
            <th>
                <a href="?sort=first_name">
                    <?= $language->translation('First Name') ?> <i class='fa fa-sort'></i>
                </a>
            </th>
            <th>
                <a href="?sort=last_name">
                    <?= $language->translation('Last Name') ?> <i class='fa fa-sort'></i>
                </a>
            </th>
            <th>
                <a href="?sort=email">
                    <?= $language->translation('E-Mail') ?> <i class='fa fa-sort'></i>
                </a>
            </th>
            <th>
                <a href="?sort=active">
                    <?= $language->translation('Active') ?> <i class='fa fa-sort'></i>
                </a>
            </th>
            <th>
                <a href="?sort=administrative">
                    <?= $language->translation('Admin') ?> <i class='fa fa-sort'></i>
                </a>
            </th>
            <th>
                <a href="?sort=logged_on">
                    <?= $language->translation('Last Login') ?> <i class='fa fa-sort'></i>
                </a>
            </th>
            <th><?= $language->translation('Action') ?></th>
        </tr>
        <?php foreach ($users as $user) : ?>
        <tr>
            <td><?= $user->firstName() ?></td>
            <td><?= $user->lastName() ?></td>
            <td><?= $user->email() ?></td>
            <td><i class="fa <?= ($user->active()) ? 'fa-check' : 'fa-times';?>"></i></td>
            <td><i class="fa <?= ($user->administrative()) ? 'fa-check' : 'fa-times';?>"></i></td>
            <td><?= $user->loggedOn()->format('Y-m-d H:i') ?></td>
            <td><a class="button" href="publisher-edit?id=<?= $user->id() ?>"><i class="fa fa-pencil"></i></a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>