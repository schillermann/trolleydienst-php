<?php return function(\DateTime $datetime): string {
    $weekday_number = (int)$datetime->format('w');
    $day_name_list = array(__('Sonntag'), __('Montag'), __('Dienstag'), __('Mittwoch'),__('Donnerstag'),__('Freitag'), __('Samstag'));
    return $day_name_list[$weekday_number];
};