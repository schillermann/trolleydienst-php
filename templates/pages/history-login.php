<?php $parse_link_ip_geo = include '../templates/helpers/parse_link_ip_geo.php';?>
<header>
    <h2>Verlauf</h2>
</header>
<nav id="nav-sub">
    <a href="history-shift.php" class="button">
        <i class="fa fa-calendar-o"></i> Schichtverlauf
    </a>
    <a href="history-login.php" class="button active">
        <i class="fa fa-sign-in"></i> Login
    </a>
    <a href="history-system.php" class="button">
        <i class="fa fa-cog"></i> System
    </a>
</nav>
<div>
    <h3>Login Fehlermeldungen</h3>
	<?php if(empty($placeholder['login_error_list'])) : ?>
        <p>Es sind keine Fehlermeldungen vorhanden.</p>
	<?php else : ?>
        <div class="table-container">
            <table>
                <tr>
                    <th>Ausgeführt am</th>
                    <th>Name</th>
                    <th>Mitteilung</th>
                </tr>
				<?php foreach ($placeholder['login_error_list'] as $shift_history) : ?>
                    <tr>
                        <td><?php echo $shift_history['created'];?></td>
                        <td><?php echo $shift_history['name'];?></td>
                        <td><?php echo $parse_link_ip_geo($shift_history['message']);?></td>
                    </tr>
				<?php endforeach; ?>
            </table>
        </div>
	<?php endif;?>
</div>