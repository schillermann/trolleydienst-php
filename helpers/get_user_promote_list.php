<?php
return function (array $user_list): array {

    $user_promote_list = array();
    $user_promote_list[$_SESSION['id_user']] = $_SESSION['name'];

    foreach ($user_list as $user)
        $user_promote_list[$user['id_user']] = $user['name'];

    return $user_promote_list;
};