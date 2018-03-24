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

        <?php if(isset($_POST['id_user']) && isset($_GET['action']) && $_GET['action'] == 'promote'): ?>
            <?php $from_uri = sprintf($placeholder['form_uri'], $placeholder['id_shift_type'], $_GET['id_shift'], $_GET['position']); ?>

            <form method="post" class="form_inline" action="?action=cancel&<?php echo $from_uri; ?>">
                <button onclick="submitForm(this)"  name="id_user" value="<?php echo $_POST['id_user'];?>">
                    <i class="fa fa-undo"></i> rückgängig
                </button>
            </form>
        <?php endif; ?>

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
                                <a href="user-details.php?id_shift_type=<?php echo (int)$_GET['id_shift_type'];?>&id_user=<?php echo $id_user; ?>" class="button promoted">
                                    <i class="fa fa-info"></i> <?php echo $user['name']; ?>
                                </a>
                            <?php endif; ?>

                        <?php endforeach; ?>

                        <?php for($free_place_counter = 0; $free_place_counter < $free_places; $free_place_counter++): ?>
                            <form method="post" class="form_inline" action="?action=promote&<?php echo $from_uri; ?>">
                                <?php echo $applicants_list; ?>
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