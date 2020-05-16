<?php

function get_price($number) {
    if ($number < 1000) {
        return $number;
    } else {
        return number_format($number, 0, ',', ' ');
    }
};

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
};

function str_xss ($str) {
    $safe_text = htmlspecialchars($str);
    return $safe_text;
};

function get_time ($final_date) {
    $secs_in_day = 86400;
    $secs_in_hour = 3600;
    $secs_in_minute = 60;
    $time_now = time();
    $final_date_timestamp = strtotime($final_date);
    $balance_to_funal_date = $final_date_timestamp - $time_now;
    $balance_to_funal_date_days = $balance_to_funal_date / $secs_in_day;
    $balance_to_funal_date_hours = $balance_to_funal_date / $secs_in_hour;
    $balance_to_funal_date_minutes = $balance_to_funal_date / $secs_in_minute;
    $time = [
        'days' => floor($balance_to_funal_date_days),
        'hours' => floor($balance_to_funal_date_hours),
        'minites' => floor($balance_to_funal_date_minutes)
    ];
    return $time;
}
