<?php return function(\DateTime $datetime): string {
    $weekday_number = (int)$datetime->format('w');
    $day_name_list = array(__('Sunday'), __('Monday'), __('Tuesday'), __('Wednesday'),__('Thursday'),__('Friday'), __('Saturday'));
    return $day_name_list[$weekday_number];
};