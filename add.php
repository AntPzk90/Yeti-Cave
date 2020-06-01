<?php
require_once('functions.php');
require_once('config.php');

if (!$config_sql) {
    $page_content = include_template('inc/404.php', []);
} else {
    // проверка авторизации пользователя
    if (isset($_SESSION['user'])) {
        $user_auth = $_SESSION['user'];
    } else {
        $user_auth = null;
        header("Location: login.php");
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // код для обработки формы
        if (isset($_POST)) {
            $lot = $_POST;
            // объявление переменной про ошибки валидации
            $form_error = false;
            // проверка ошибки валидации (каждого поля отдельно)
            $errors = validate_add_lot($lot);
        }
        // перемещение картинки
        if (isset($_FILES['lot-image'])) {
            $lot_img = $_FILES['lot-image'];
            $tmp_name = $lot_img['tmp_name'];
            $path = $lot_img['name'];
            $lot['path'] = 'uploads/' . $lot_img['name'];
            $lot_file = move_uploaded_file($tmp_name, 'uploads/' . $path);
            $file_size = $lot_img['size'];
            $file_type = $lot_img['type'];
            // вылидиция картинки
            if (validate_add_lot_file($file_type, $file_size)) {
                $errors['file_type'] = true;
            }
        }
        if (!check_errors($errors)) {
            // добавление нового лота в БД
            $lot_category = get_ctegory_id($lot['category']);
            $sql = 'INSERT INTO lots (title_lot, dscr, img_path, start_price, price_lot, step, dt_fin, id_user, id_winner, id_category)
            VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

            $stmt = db_get_prepare_stmt($config_sql, $sql, [$lot['lot-name'], $lot['message'], $lot['path'], $lot['lot-rate'], $lot['lot-rate'], $lot['lot-step'], $lot['lot-date'], $user_auth['id'],  $user_auth['id'], $lot_category]);
            $result = mysqli_stmt_execute($stmt);
            if ($sql) {
                //заголовок для перенаправления пользователя
                header("Location: index.php");
            }
        }
        $form_error = check_errors($errors);
    }

    $sql = 'SELECT `id`, `title_category`, `symbol`
    FROM categories';
    $result_categories = mysqli_query($config_sql, $sql);
    $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);

    $page_content = include_template('inc/add-page.php', [
        'categories' => $categories,
        'errors' => $errors,
        'form_error' => $form_error,
        'lot_value' => $lot
    ]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeti Cave',
    'user_auth' => $user_auth
]);
print($layout_content);
