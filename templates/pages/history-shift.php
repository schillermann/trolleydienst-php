<header>
    <h2><?php echo __("Verlauf"); ?></h2>
</header>
<nav id="nav-sub">
    <a href="./history-shift.php" class="button active">
        <i class="fa fa-calendar-o"></i> <?php echo __("Schichtverlauf"); ?>
    </a>
    <a href="./history-login.php" class="button">
        <i class="fa fa-sign-in"></i> <?php echo __("Login"); ?>
    </a>
    <a href="./history-system.php" class="button">
        <i class="fa fa-cog"></i> <?php echo __("System"); ?>
    </a>
</nav>
<div>
    <h3><?php echo __("Schichtverlauf"); ?></h3>
    <h4><?php echo __("Fehlermeldungen"); ?></h4>
	<?php if(empty($placeholder['shift_error_list'])) : ?>
        <p><?php echo __("Es sind keine Fehlermeldungen vorhanden."); ?></p>
	<?php else : ?>
        <div class="table-container">
            <table>
                <tr>
                    <th><?php echo __("Ausgeführt am"); ?></th>
                    <th><?php echo __("Ausgeführt von"); ?></th>
                    <th><?php echo __("Mitteilung"); ?></th>
                </tr>
				<?php foreach ($placeholder['shift_error_list'] as $shift_history) : ?>
                    <tr>
                        <td><?php echo $shift_history['created'];?></td>
                        <td><?php echo $shift_history['name'];?></td>
                        <td><?php echo $shift_history['message'];?></td>
                    </tr>
				<?php endforeach; ?>
            </table>
        </div>
	<?php endif;?>

    <h4><?php echo __("Statusmeldungen"); ?></h4>
	<?php if(empty($placeholder['shift_success_list'])) : ?>
        <p><?php echo __("Es sind keine Statusmeldungen vorhanden."); ?></p>
	<?php else : ?>
        <div class="table-container">
            <table>
                <tr>
                    <th><?php echo __("Ausgeführt am"); ?></th>
                    <th><?php echo __("Ausgeführt von"); ?></th>
                    <th><?php echo __("Mitteilung"); ?></th>
                </tr>
				<?php foreach ($placeholder['shift_success_list'] as $shift_history) : ?>
                    <tr>
                        <td><?php echo $shift_history['created'];?></td>
                        <td><?php echo $shift_history['name'];?></td>
                        <td><?php echo $shift_history['message'];?></td>
                    </tr>
				<?php endforeach; ?>
            </table>
        </div>
	<?php endif;?>
</div>