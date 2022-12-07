<header>
    <h2><?= __('History') ?></h2>
</header>
<nav id="nav-sub">
    <a href="./shift-history" class="button active">
        <i class="fa fa-calendar-o"></i> <?= __('Shift History') ?>
    </a>
    <a href="./login-history" class="button">
        <i class="fa fa-sign-in"></i> <?= __('Login') ?>
    </a>
    <a href="./system-history" class="button">
        <i class="fa fa-cog"></i> <?= __('System') ?>
    </a>
</nav>
<div>
    <h3><?= __('Shift History') ?></h3>
    <h4><?= __('Error Messages') ?></h4>
	<?php if(empty($placeholder['shift_error_list'])) : ?>
        <p><?= __('There are no error messages.') ?></p>
	<?php else : ?>
        <div class="table-container">
            <table>
                <tr>
                    <th><?= __('Error Date') ?></th>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Error Message') ?></th>
                </tr>
				<?php foreach ($placeholder['shift_error_list'] as $shift_history) : ?>
                    <tr>
                        <td><?= $shift_history['created'];?></td>
                        <td><?= $shift_history['name'];?></td>
                        <td><?= $shift_history['message'];?></td>
                    </tr>
				<?php endforeach ?>
            </table>
        </div>
	<?php endif;?>

    <h4><?= __('Status Messages') ?></h4>
	<?php if(empty($placeholder['shift_success_list'])) : ?>
        <p><?= __('There are no status messages.') ?></p>
	<?php else : ?>
        <div class="table-container">
            <table>
                <tr>
                    <th><?= __('Error Date') ?></th>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Error Message') ?></th>
                </tr>
				<?php foreach ($placeholder['shift_success_list'] as $shift_history) : ?>
                    <tr>
                        <td><?= $shift_history['created'];?></td>
                        <td><?= $shift_history['name'];?></td>
                        <td><?= $shift_history['message'];?></td>
                    </tr>
				<?php endforeach ?>
            </table>
        </div>
	<?php endif;?>
</div>