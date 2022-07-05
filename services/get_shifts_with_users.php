<?php return function (\PDO $connection, int $id_shift_type): array {
    
    $get_users_from_shift = include '../services/get_users_from_shift.php';
    $shift_day_list = array();
    foreach (App\Tables\Shifts::select_all($connection, $id_shift_type) as $shift_day) {

        $shift_datetime_from = new DateTime($shift_day['datetime_from']);
        $get_weekday = include '../helpers/get_weekday.php';
        $id_shift = $shift_day['id_shift'];

        $shift_day_list[$id_shift] = [
            'date' => $shift_datetime_from->format(__('d/m/Y')),
            'day' => $get_weekday($shift_datetime_from),
            'route' => $shift_day['route'],
            'color_hex' => $shift_day['color_hex'],
            'shifts' => []
        ];
        $user_list = $get_users_from_shift($connection, $id_shift);
        for ($shift_position = 1; $shift_position <= $shift_day['number']; $shift_position++) {

            $shift_time_from = $shift_datetime_from->format('H:i');
            $shift_time_to = date_modify($shift_datetime_from, '+' . (int)$shift_day['minutes_per_shift'] . ' minutes');
            $shift_time = $shift_time_from . ' - ' . $shift_time_to->format('H:i');

            $shift_day_list[$id_shift]['shifts'][$shift_time] = (isset($user_list[$shift_position]))? $user_list[$shift_position] : [];
        }
    }

    return $shift_day_list;
};