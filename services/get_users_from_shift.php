<?php return function (\PDO $connection, int $id_shift) {
    $user_list = array();

    foreach (Tables\ShiftUserMaps::select_all($connection, $id_shift) as $users) {
        $shift_position = (int)$users['position'];
        $id_user = $users['id_user'];

        $user_list[$shift_position][$id_user] = $users['name'];
    }
    return $user_list;
};