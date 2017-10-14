<?php
return function (int $length = 12): string {
    $password_string = '!@#$%&()=*-:&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
    return substr(str_shuffle($password_string), 0, $length);
};