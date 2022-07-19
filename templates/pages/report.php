<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?= __('Reports') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./report-submit.php" class="button active">
        <i class="fa fa-plus"></i> <?= __('Submit Report') ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <label for="id_shift_type"><?= __('Shift Type') ?></label>
        <select id="id_shift_type" name="id_shift_type">
            <?php foreach($placeholder['shifttype_list'] as $shifttype): ?>
                <option value="<?= $shifttype['id_shift_type'];?>" <?= (isset($_POST['id_shift_type']) && $_POST['id_shift_type'] == $shifttype['id_shift_type'])? 'selected':'';?>>
                    <?= $shifttype['name'];?>
                </option>
            <?php endforeach;?>
        </select>
        <label for="report_from"><?= __('from:') ?></label>
        <input id="report_from" name="report_from" type="date" value="<?= $placeholder['report_from'];?>">
        <label for="report_to"><?= __('to:') ?></label>
        <input id="report_to" name="report_to" type="date" value="<?= $placeholder['report_to'];?>">
        <button name="filter" class="active">
            <i class="fa fa-search"></i> <?= __('Filter') ?>
        </button>
    </form>
    <div class="table-container">
        <?php foreach ($placeholder['report_list'] as $id_report => $report): ?>
            <table>
                <thead>
                    <tr>
                        <th colspan="2" style="background-color: #d5c8e4">
			<?= $report['day'];?>, <?= $report['datetime'];?> - <?= $report['name'];?> - <?= $report['route'];?>
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            <p>
                                <a href="./report.php?id_report=<?= $id_report;?>" class="button warning">
                                    <i class="fa fa-trash-o"></i> <?= __('Delete') ?>
                                </a>
                                <span><strong><?= __('Created on') ?>:</strong> <?= $report['created'];?></span>
                            </p>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if($report['book'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?= __('Books') ?>
                        </td>
                        <td>
                            <?= $report['book'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['brochure'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?= __('Brochures') ?>
                        </td>
                        <td>
                            <?= $report['brochure'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['bible'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?= __('Bibles') ?>
                        </td>
                        <td>
                            <?= $report['bible'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['magazine'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?= __('Magazines') ?>
                        </td>
                        <td>
                            <?= $report['magazine'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['tract'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?= __('Tracts') ?>
                        </td>
                        <td>
                            <?= $report['tract'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['address'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?= __('Addresses') ?>
                        </td>
                        <td>
                            <?= $report['address'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['talk'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?= __('Conversations') ?>
                        </td>
                        <td>
                            <?= $report['talk'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if(!empty($report['publisher_note'])): ?>
                    <tr>
                        <td class="report-label">
                        <?= __('Notes') ?>
                        </td>
                        <td>
                            <?= $report['publisher_note'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                </tbody>
            </table>
        <?php endforeach;?>
    </div>
</div>