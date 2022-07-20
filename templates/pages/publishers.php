<header>
    <h2><?= $language->translation('Publisher') ?></h2>
</header>
<form method="get">
    <div class="from-button">
        <a href="user-add" class="button active">
            <i class="fa fa-plus"></i> <?= $language->translation('Create Publisher') ?>
        </a>
        <input name="search" type="search" placeholder="<?= $language->translation('Search Publishers') ?>" value="<?= $searchPattern ?>">
        <input type="hidden" name="sortcolumn" value="<?= $sortColumn?>"> 
        <input type="hidden" name="sortorder" value="<?= $sortOrder?>"> 
        <button type="submit">
            <i class="fa fa-search"></i>
        </button>
    </div>
</form>
<div class="table-container">
    <table>
        <tr>
            <th>
                <?= $language->translation('First Name') ?>
                <a href="?sortcolumn=first_name&sortorder=asc&search=<?= $searchPattern?>"><i class='fa fa-sort-up'></a></i>
                <a href="?sortcolumn=first_name&sortorder=desc&search=<?= $searchPattern?>"><i class='fa fa-sort-down'></a></i>
            </th>
            <th>
                <?= $language->translation('Last Name') ?>
                <a href="?sortcolumn=last_name&sortorder=asc&search=<?= $searchPattern?>"><i class='fa fa-sort-up'></a></i>
                <a href="?sortcolumn=last_name&sortorder=desc&search=<?= $searchPattern?>"><i class='fa fa-sort-down'></a></i>
            </th>
            <th>
                <?= $language->translation('E-Mail') ?>
                <a href="?sortcolumn=email&sortorder=asc&search=<?= $searchPattern?>"><i class='fa fa-sort-up'></a></i>
                <a href="?sortcolumn=email&sortorder=desc&search=<?= $searchPattern?>"><i class='fa fa-sort-down'></a></i>
            </th>
            <th>
                <?= $language->translation('Active') ?>
                <a href="?sortcolumn=active&sortorder=asc&search=<?= $searchPattern?>"><i class='fa fa-sort-up'></a></i>
                <a href="?sortcolumn=active&sortorder=desc&search=<?= $searchPattern?>"><i class='fa fa-sort-down'></a></i>
            </th>
            <th>
                <?= $language->translation('Admin') ?>
                <a href="?sortcolumn=administrative&sortorder=asc&search=<?= $searchPattern?>"><i class='fa fa-sort-up'></a></i>
                <a href="?sortcolumn=administrative&sortorder=desc&search=<?= $searchPattern?>"><i class='fa fa-sort-down'></a></i>
            </th>
            <th>
                <?= $language->translation('Last Login') ?>
                <a href="?sortcolumn=logged_on&sortorder=asc&search=<?= $searchPattern?>"><i class='fa fa-sort-up'></a></i>
                <a href="?sortcolumn=logged_on&sortorder=desc&search=<?= $searchPattern?>"><i class='fa fa-sort-down'></a></i>
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