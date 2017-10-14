<?php
if(!isset($_GET['id_shift_type'])) {
    header('location: info.php');
    return;
}

$placeholder = require 'includes/init_page.php';

if(isset($_POST['save'])) {
	Tables\History::delete_old_entries($database_pdo);
	Tables\Shifts::delete_old_entries($database_pdo);
    Tables\ShiftUserMaps::delete_old_entries($database_pdo);

    $date_from = include 'filters/post_date_from.php';

    $merge_date_and_time = include 'modules/merge_date_and_time.php';
    $shift_datetime_from = $merge_date_and_time($date_from, $_POST['time_from']);

    if ($_POST['shiftday_series_until'] != '') {
        $shift_datetime_until = new \DateTime($_POST['shiftday_series_until']);
        $shift_datetime_until->setTime(23,59);
    } else {
        $shift_datetime_until = clone $shift_datetime_from;
    }

    $shift = new Models\Shift(
        0,
        (int)$_GET['id_shift_type'],
        include 'filters/post_route.php',
        $shift_datetime_from,
        (int)$_POST['number'],
        $_POST['hours_per_shift'] * 60,
        include 'filters/post_color_hex.php'
    );

    while ($shift_datetime_from <= $shift_datetime_until) {

        if(Tables\Shifts::insert($database_pdo, $shift))
            $placeholder['message']['success'][] = $shift_datetime_from->format('d.m.Y') . ' ' . $shift_datetime_from->format('H:i');
        else
            $placeholder['message']['error'][] = $shift_datetime_from->format('d.m.Y') . ' ' . $shift_datetime_from->format('H:i');

        $shift_datetime_from->add(new \DateInterval('P7D'));
    }
}

$placeholder['id_shift_type'] = (int)$_GET['id_shift_type'];

$render_page = include 'includes/render_page.php';
echo $render_page($placeholder);