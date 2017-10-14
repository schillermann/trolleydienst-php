<?php return function(\DateTime $datetime): string {
    $weekday_number = (int)$datetime->format('w');
    $day_name_list = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch','Donnerstag','Freitag', 'Samstag');
    return $day_name_list[$weekday_number];
};