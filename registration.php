<?php
require_once('functions.php');
require_once('config.php');

if (!$config_sql) {
    $page_content = include_template('inc/404.php', []);
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // код для обработки формы
        if (isset($_POST)) {
            $new_user = $_POST;
            // объявление переменной про ошибки валидации
            $form_error = false;
            // проверка ошибки валидации (каждого поля отдельно)
            $errors = validate_redistration_form($new_user);
            // запрос на получение email
            $email = mysqli_real_escape_string($config_sql, $new_user['email']);
            $sql = "SELECT id FROM users WHERE email = '$email'";
            $result_email = mysqli_query($config_sql, $sql);
            // проверка на наличие такого tmail в базе
            if (mysqli_num_rows($result_email) > 0) {
                $errors['email'] = true;
            } else if (!check_errors($errors) && filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
                // делаем соепок пароля
                $password = password_hash($new_user['password'], PASSWORD_DEFAULT);
                // добавление нового пользователя в БД

                $sql = 'INSERT INTO users (email, name_user, pass, contacts)
                VALUES ( ?, ?, ?, ?)';
                $stmt = db_get_prepare_stmt($config_sql, $sql, [$new_user['email'], $new_user['name'], $password, $new_user['message']]);
                $result = mysqli_stmt_execute($stmt);
                if ($sql) {
                    $sql = "SELECT `id` FROM `users` WHERE `email`='" . $new_user['email'] . "'";
                    $result = mysqli_query($config_sql, $sql);
                    $id = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    $id_lot_and_bid = $id[0]['id'];
                    if ($sql) {
                        // вносим в базу привязку id пользователя к id_lot и id_bid
                        $sql = "UPDATE users SET id_lot = '" . $id_lot_and_bid . "', id_bid = '" . $id_lot_and_bid . "'
                        WHERE id = '" . $id_lot_and_bid . "'";
                        $result = mysqli_query($config_sql, $sql);
                        if ($sql) {
                            //заголовок для перенаправления пользователя
                            header("Location: login.php");
                        }
                    }
                }
            }
            // проверка наличия ошибок в форме
            $form_error = check_errors($errors);
        }
    }
    $sql = 'SELECT `id`, `title_category`, `symbol`
    FROM categories';
    $result_categories = mysqli_query($config_sql, $sql);
    $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);

    $page_content = include_template('inc/sign-up.php', [
        'categories' => $categories,
        'errors' => $errors,
        'form_error' => $form_error,
        'new_user_value' => $new_user
    ]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeti Cave'
]);
print($layout_content);
