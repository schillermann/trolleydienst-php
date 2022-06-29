<?php
return function (\DateTime $date, string $time) : \DateTime {

    $datetime = clone $date;
    $time_split = explode(':', $time);
    $time_hour = $time_split[0];
    $time_minute = $time_split[1];

    $datetime->setTime((int)$time_hour, (int)$time_minute);

    return $datetime;
};