<?php include '../templates/pagesnippets/note-box.php' ?>
<header>
    <h2><?php echo __("Berichte"); ?></h2>
</header>
<nav id="nav-sub">
    <a href="./report-submit.php" class="button active">
        <i class="fa fa-plus"></i> <?php echo __("Bericht abgeben"); ?>
    </a>
</nav>
<div class="container-center">
    <form method="post">
        <label for="id_shift_type"><?php echo __("Schichtart"); ?></label>
        <select id="id_shift_type" name="id_shift_type">
            <?php foreach($placeholder['shifttype_list'] as $shifttype): ?>
                <option value="<?php echo $shifttype['id_shift_type'];?>" <?php echo (isset($_POST['id_shift_type']) && $_POST['id_shift_type'] == $shifttype['id_shift_type'])? 'selected':'';?>>
                    <?php echo $shifttype['name'];?>
                </option>
            <?php endforeach;?>
        </select>
        <label for="report_from"><?php echo __("von:"); ?></label>
        <input id="report_from" name="report_from" type="date" value="<?php echo $placeholder['report_from'];?>">
        <label for="report_to"><?php echo __("bis:"); ?></label>
        <input id="report_to" name="report_to" type="date" value="<?php echo $placeholder['report_to'];?>">
        <button name="filter" class="active">
            <i class="fa fa-search"></i> <?php echo __("filtern"); ?>
        </button>
    </form>
    <div class="table-container">
        <?php foreach ($placeholder['report_list'] as $id_report => $report): ?>
            <table>
                <thead>
                    <tr>
                        <th colspan="2" style="background-color: #d5c8e4">
			<?php echo $report['day'];?>, <?php echo $report['datetime'];?> - <?php echo $report['name'];?> - <?php echo $report['route'];?>
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            <p>
                                <a href="./report.php?id_report=<?php echo $id_report;?>" class="button warning">
                                    <i class="fa fa-trash-o"></i> <?php echo __("löschen"); ?>
                                </a>
                                <span><strong><?php echo __("Erstellt am"); ?>:</strong> <?php echo $report['created'];?></span>
                            </p>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if($report['book'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?php echo __("Bücher"); ?>
                        </td>
                        <td>
                            <?php echo $report['book'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['brochure'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?php echo __("Broschüren"); ?>
                        </td>
                        <td>
                            <?php echo $report['brochure'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['bible'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?php echo __("Bibel"); ?>
                        </td>
                        <td>
                            <?php echo $report['bible'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['magazine'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?php echo __("Zeitschriften"); ?>
                        </td>
                        <td>
                            <?php echo $report['magazine'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['tract'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?php echo __("Traktate"); ?>
                        </td>
                        <td>
                            <?php echo $report['tract'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['address'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?php echo __("Adressen"); ?>
                        </td>
                        <td>
                            <?php echo $report['address'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if($report['talk'] > 0): ?>
                    <tr>
                        <td class="report-label">
                        <?php echo __("Gespräche"); ?>
                        </td>
                        <td>
                            <?php echo $report['talk'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                    <?php if(!empty($report['note_user'])): ?>
                    <tr>
                        <td class="report-label">
                        <?php echo __("Bemerkung"); ?>
                        </td>
                        <td>
                            <?php echo $report['note_user'];?>
                        </td>
                    </tr>
                    <?php endif;?>
                </tbody>
            </table>
        <?php endforeach;?>
    </div>
</div>