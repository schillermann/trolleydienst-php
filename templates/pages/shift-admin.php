<?php ob_start();
include 'templates/pagesnippets/user_promote_list.php';
$applicants_list = ob_get_contents();
ob_end_clean();
?>

<?php if (isset($placeholder['message'])) : ?>
    <div id="note-box" class="fade-in">
        <?php if (isset($placeholder['message']['success'])) : ?>
            <p class="success">
                <?php echo $placeholder['message']['success']; ?>
            </p>
        <?php elseif(isset($placeholder['message']['error'])): ?>
            <p class="error">
                <?php echo $placeholder['message']['error']; ?>
            </p>
        <?php endif; ?>

        <button onclick="closeNoteBox(); return false;">
            <i class="fa fa-times"></i> schliessen
        </button>
        <form method="post" class="form_inline">
            <?php if(isset($_POST['promote_id_user'])): ?>
                <button>
                    <i class="fa fa-undo"></i> rückgängig
                </button>
                <input type="hidden" name="id_shift" value="<?php echo (int)$_POST['id_shift'];?>">
                <input type="hidden" name="position" value="<?php echo (int)$_POST['position'];?>">
                <input type="hidden" name="cancel_id_user" value="<?php echo (int)$_POST['promote_id_user'];?>">
            <?php endif; ?>
        </form>

    </div>
<?php endif; ?>

<header>
    <h2><?php echo $placeholder['shift_type']['name'];?> Schichten</h2>
    <?php if(!empty($placeholder['shift_type']['info'])): ?>
        <div class="info-box">
            <p>
                <i class="fa fa-bullhorn"></i>
                <?php echo $placeholder['shift_type']['info'];?>
            </p>
        </div>
    <?php endif;?>
</header>
<nav>
    <a href="shift-add.php?id_shift_type=<?php echo $placeholder['id_shift_type']?>" tabindex="1" class="button active">
        <i class="fa fa-plus"></i> Neue Schichten
    </a>
</nav>

<div class="table-container">
    <?php foreach ($placeholder['shift_day'] as $id_shift => $shift_list) : ?>
        <table id="id_shift_<?php echo $id_shift; ?>">
            <thead>
            <tr>
                <th colspan="2" style="background-color: <?php echo $shift_list['color_hex'];?>">
                    <?php echo $shift_list['day']; ?>,
                    <?php echo $shift_list['date']; ?> -
                    <?php echo $shift_list['route']; ?>
                </th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="2" style="background-color: <?php echo $shift_list['color_hex'];?>">
                    <p>
                        <a href="shift-edit.php?id_shift_type=<?php echo $placeholder['id_shift_type']?>&id_shift=<?php echo $id_shift;?>" class="button">
                            <i class="fa fa-pencil"></i> bearbeiten
                        </a>
                    </p>
                </td>
            </tr>
            </tfoot>
            <?php $position = 0; ?>
            <tbody>
            <?php foreach ($shift_list['shifts'] as $shift_time => $user_list) : ?>

                <?php $free_places = (int)$placeholder['shift_type']['user_per_shift_max'] - count($user_list); ?>
                <?php $from_uri = sprintf($placeholder['form_uri'], $placeholder['id_shift_type'], $id_shift, ++$position); ?>
                <tr>
                    <td class="shift-time">
                        <?php echo $shift_time;?>
                    </td>
                    <td>
                        <?php foreach ($user_list as $id_user => $user) : ?>

                            <?php if($id_user === $_SESSION['id_user']): ?>
                                <form method="post" class="form_inline" action="?action=cancel&<?php echo $from_uri; ?>">
                                    <button class="enable" onclick="submitForm(this)" name="id_user" value="<?php echo $id_user; ?>">
                                        <i class="fa fa-thumbs-o-up"></i> <?php echo $user['name']; ?>
                                    </button>
                                </form>
                            <?php else: ?>
                                <form method="post" class="form_inline" action="?<?php echo $from_uri; ?>">
                                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                                    <select name="action" class="button promoted" onchange="submitForm(this)">
                                        <option value=""><?php echo $user['name'];?></option>
                                        <option value="userinfo">Kontaktdaten</option>
                                        <option value="cancel">Löschen</option>
                                    </select>
                                </form>
                            <?php endif; ?>

                        <?php endforeach; ?>

                        <?php for($free_place_counter = 0; $free_place_counter < $free_places; $free_place_counter++): ?>
                            <form method="post" class="form_inline" action="?action=promote&<?php echo $from_uri; ?>">
                                <?php echo $applicants_list;?>
                            </form>
                        <?php endfor;?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</div>
<script type="text/javascript" src="js/submit-form.js"></script>