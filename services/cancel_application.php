<?php
return function (\PDO $connection, int $id_shift, int $position,  int $id_user): bool {

    $cancel_application_success = App\Tables\ShiftUserMaps::delete($connection, $id_shift, $position, $id_user);

    $shift = App\Tables\Shifts::select($connection, $id_shift);
    $shift_type_name = App\Tables\ShiftTypes::select_name($connection, $shift['id_shift_type']);
    $applicant_name = App\Tables\Users::select_name($connection, $id_user);
    $shift_datetime = new \DateTime($shift['datetime_from']);
    $shift_datetime_format = $shift_datetime->format(__('d.m.Y'));

    if ($cancel_application_success) {
        if(!DEMO) {
            $send_mail_cancel_application = include '../services/send_mail_applicant_action.php';
            $send_mail_cancel_application($connection, $id_shift, $position, $id_user, $shift_datetime, App\Tables\EmailTemplates::APPLICATION_CANCEL);
        }
        
        $history_type = App\Tables\History::SHIFT_WITHDRAWN_SUCCESS;
        $message = __("Die ") . $shift_type_name . __(" Schicht Bewerbung vom ") . $shift_datetime_format . __(" Schicht ") . $position . __(" für ") . $applicant_name . __(" wurde zurück gezogen.");
    } else {
        $history_type = App\Tables\History::SHIFT_WITHDRAWN_ERROR;
        $message = __("Die ") . $shift_type_name . __(" Schicht Bewerbung vom ") . $shift_datetime_format . __(" Schicht ") . $position . __(" für ") . $applicant_name . __(" konnte nicht zurück gezogen werden!");
    }

    App\Tables\History::insert(
        $connection,
        $_SESSION['name'],
        $history_type,
        $message
    );

    return $cancel_application_success;
};