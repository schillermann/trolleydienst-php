<?php $parse_link_ip_geo = include '../templates/helpers/parse_link_ip_geo.php';?>
<header>
    <h2><?= __('History') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./history-shift.php" class="button">
        <i class="fa fa-calendar-o"></i> <?= __('Shift History') ?>
    </a>
    <a href="./history-login.php" class="button active">
        <i class="fa fa-sign-in"></i> <?= __('Login') ?>
    </a>
    <a href="./history-system.php" class="button">
        <i class="fa fa-cog"></i> <?= __('System') ?>
    </a>
</nav>
<div>
    <h3><?= __('Login error messages') ?></h3>
	<?php if(empty($placeholder['login_error_list'])) : ?>
        <p><?= __('There are no error messages.') ?></p>
	<?php else : ?>
        <div class="table-container">
            <table>
                <tr>
                    <th><?= __('Error Date') ?></th>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Error Message') ?></th>
                </tr>
				<?php foreach ($placeholder['login_error_list'] as $shift_history) : ?>
                    <tr>
                        <td><?= $shift_history['created'];?></td>
                        <td><?= $shift_history['name'];?></td>
                        <td><?= $parse_link_ip_geo($shift_history['message']);?></td>
                    </tr>
				<?php endforeach ?>
            </table>
        </div>
	<?php endif;?>
</div>