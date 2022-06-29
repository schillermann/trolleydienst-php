<?php return function (\PDO $connection, int $id_shift, int $position, int $id_user): bool {

    $shift = App\Tables\Shifts::select($connection, $id_shift);
    $shift_type_name = App\Tables\ShiftTypes::select_name($connection, $shift['id_shift_type']);
    $user_name = App\Tables\Users::select_name($connection, $id_user);

    $promote_user_success = App\Tables\ShiftUserMaps::insert($connection, $id_shift, $position, $id_user);

    $nextShiftInMinutes = (int)$shift['minutes_per_shift'] * ($position - 1);

	$shift_from = date_modify(new \DateTime($shift['datetime_from']), '+' . $nextShiftInMinutes . ' minutes');
	$shift_to = clone $shift_from;
	$shift_to->add(new DateInterval('PT' . (int)$shift['minutes_per_shift'] . 'M'));
    $shift_datetime = new \DateTime($shift['datetime_from']);
    $shift_datetime_format = $shift_datetime->format(__('d.m.Y'));

    if ($promote_user_success) {

        if(!DEMO) {
            $send_mail_shift_date = include '../services/send_mail_shift_date.php';
            $send_mail_shift_date($connection, $id_shift, $shift_from, $shift_to, $shift_type_name, $id_user);

            $send_mail_to_participants_of_shift = include '../services/send_mail_applicant_action.php';
            $send_mail_to_participants_of_shift($connection, $id_shift, $position, $id_user, $shift_from);
        }

        $history_type = App\Tables\History::SHIFT_PROMOTE_SUCCESS;
        $message = __('Die ') . $shift_type_name . __(' Schicht Bewerbung vom ') . $shift_datetime_format . __(' Schicht ') . $position . __(' für ') . $user_name . __(' wurde angenommen.');
    } else {
        $history_type = App\Tables\History::SHIFT_PROMOTE_ERROR;
        $message = __('Die ') . $shift_type_name . __(' Schicht Bewerbung vom  ') . $shift_datetime_format . __(' Schicht ') . $position . __(' für ') . $user_name . __(' konnte nicht angenommen werden!');
    }

    App\Tables\History::insert(
        $connection,
		$_SESSION['name'],
        $history_type,
        $message
    );

    return $promote_user_success;
};