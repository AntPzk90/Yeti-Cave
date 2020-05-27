<?php

/**
 * возвразает цену с нужным форматом (с пробелом)
 *
 * @param $number цена без пробела (8000)
 *
 * @return number_format цена с пробелом (8 000)
 */
function get_price($number) {
    if ($number < 1000) {
        return $number;
    } else {
        return number_format($number, 0, ',', ' ');
    }
};

// подключение шаблона

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

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $str строка которую нужно обезопасить
 * @return safe_text безопасный текст
 */

function str_xss ($str) {
    $safe_text = htmlspecialchars($str);
    return $safe_text;
};

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $final_date строка которую нужно обезопасить
 * @return time['format'] возвращаем нужный нам промежуток времени (дни, часы. минуты)
 */


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

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}


/**
 * проверяет чтоб дата была валидной
 *
 * @param $date выбранная дата
 * @return bool true вылидная дата, false не валидная
 */

function check_date ($date) {
    if (strtotime($date) < time()) {
        return false;
    } else {
        return true;
    }
}

/**
 * проверка на наличие ошибок при валидации
 *
 * @param $errors_arr выбранная дата
 * @return $form_error bool true ошибки есть, false ошибок нет
 */
function check_errors ($errors_arr) {
    $form_error = false;
    foreach ($errors_arr as $error) {
        if ($error) {
            $form_error = true;
        }
    }
    return $form_error;
}
/**
 * вфлидация полей формы:
 * -название лота
 * -ктегория
 * -описание
 * -цена (стартовая)
 * -шаг
 * -дата
 * @param $lot значение из полей формы взятые из $_POST
 * @return $errors arr флаги ошибок в полях
 */
function validate_add_lot ($lot) {
    $errors = [
        'name' => false,
        'category' => false,
        'message' => false,
        'rate' => false,
        'step' => false,
        'date' => false,
        'file_type' => false
    ];
    $form_error = false;
    // проверка валидации
    if (empty($lot['lot-name'])) {
        $errors['name'] = true;
    }
    if ($lot['category'] === 'Выберите категорию') {
        $errors['category'] = true;
    }
    if (empty($lot['message'])) {
        $errors['message'] = true;
    }
    if (empty($lot['lot-rate'])) {
        $errors['rate'] = true;
    } else if ($lot['lot-rate'] < 0 || !intval($lot['lot-rate'])) {
        $errors['rate'] = true;
    }
    if (empty($lot['lot-step'])) {
        $errors['step'] = true;
    } else if ($lot['lot-step'] < 0 || !intval($lot['lot-step'])) {
        $errors['step'] = true;
    }
    if (empty($lot['lot-date'])) {
        $errors['date'] = true;
    } else if(!check_date($lot['lot-date'])) {
        $errors['date'] = true;
    }

    return $errors;
}
/**
 * вфлидация полей формы:
 * - файл
 * @param $file_type проверки изображения на MIMY_TYPE
 * @param $file_size проверка файла на размер
 * @return $error bool флаги ошибки false нет, true есть
 */
function validate_add_lot_file ($file_type, $file_size) {
    $error = false;
    if ($file_type == 'image/jpg' || $file_type == 'image/jpeg' || $file_type == 'image/png') {
        $error = false;
    } else {
        $error = true;
    }
    if ($file_size > 200000) {
        $error = true;
    }
    return $error;
}
/**
 * получаем id категории
 * @param $category_txt название категории
 * @return int id категории
 */
function get_ctegory_id ($category_txt) {
    switch ($category_txt) {
        case 'Доски и лыж':
            return 1;
            break;
        case 'Крепления':
            return 2;
            break;
        case 'Ботинки':
            return 3;
            break;
        case 'Одежда':
            return 4;
            break;
        case 'Инструменты':
            return 5;
            break;
        case 'Разное':
            return 6;
            break;
    }
}
