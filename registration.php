<?php
require_once('functions.php');
require_once('config.php');

if (!$config_sql) {
    $page_content = include_template('inc/404.php', []);
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // код для обработки формы
        if(isset($_POST)) {
            $new_user = $_POST;
            $form_error = false;
            $errors = validate_redistration_form($new_user);

            $email = mysqli_real_escape_string($config_sql, $new_user['email']);
            $sql = "SELECT id FROM users WHERE email = '$email'";
            $result_email = mysqli_query($config_sql, $sql);

            if (mysqli_num_rows($result_email) > 0) {
                $errors['email'] = true;
            } else if (!check_errors($errors)) {

                $password = password_hash($new_user['pass'], PASSWORD_DEFAULT);
                $sql = 'INSERT INTO users (email, name_user, pass, contacts)
                VALUES ( ?, ?, ?, ?)';

                $stmt = db_get_prepare_stmt($config_sql, $sql, [$new_user['email'], $new_user['name'], $password, $new_user['message']]);
                $result = mysqli_stmt_execute($stmt);

                if($sql) {

                    $sql = "SELECT `id` FROM `users` WHERE `email`='".$new_user['email']."'";
                    $result = mysqli_query($config_sql, $sql);
                    $id = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    $id_lot_and_bid = $id[0]['id'];
                    print($id_lot_and_bid);
                    if($sql) {
                        // нужно обновить
                        $sql = "UPDATE users SET id_lot = '".$id_lot_and_bid."', id_bid = '".$id_lot_and_bid."'
                        WHERE id = '".$id_lot_and_bid."'";
                        $result = mysqli_query($config_sql, $sql);

                        if($sql) {
                            //заголовок для перенаправления пользователя
                            header("Location: login.php");
                        }
                    }
                }
            }
            $form_error = check_errors($errors);
        }
    }

    $sql = 'SELECT `id`, `title_category`, `symbol`
    FROM categories';
    $result_categories = mysqli_query($config_sql, $sql);
    $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);

    $page_content = include_template('inc/sign-up.php', [
        'items' => $items,
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
