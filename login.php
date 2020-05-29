<?php
require_once('functions.php');
require_once('config.php');

if (!$config_sql) {
    $page_content = include_template('inc/404.php', []);
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // код для обработки формы
        if(isset($_POST)) {
            $user = $_POST;
            // объявление переменной про ошибки валидации
            $form_error = false;
            // проверка ошибки валидации (каждого поля отдельно)
            $errors = validate_login_form($user);
            // запрос на получение email
            $sql = "SELECT `id` FROM `users` WHERE `email`='".$user['email']."'";
            $result_email = mysqli_query($config_sql, $sql);
            $user_email_ident = mysqli_fetch_all($result_email, MYSQLI_ASSOC);
            // проверка на наличие такого tmail в базе
            if (!$user_email_ident) {
                $errors['email'] = true;
            }
            if ($user_email_ident && !check_errors($errors)) {
                $sql = "SELECT * FROM `users` WHERE `email`='".$user['email']."'";
                $result_pass = mysqli_query($config_sql, $sql);
                $user_from_sql = mysqli_fetch_all($result_pass, MYSQLI_ASSOC);
                $password_hash = $user_from_sql[0]['pass'];
                $user_auth = $user_from_sql[0];
                if($sql) {
                    if(password_verify($user['password'], $password_hash)) {
                        $_SESSION['user']['id'] = $user_auth['id'];
                        $_SESSION['user']['name'] = $user_auth['name_user'];
                        $error_password_verify = false;
                        header("Location: index.php");
                        exit();
                    } else {
                        $error_password_verify = true;
                    }
                }
            }
        }
    }

    $sql = 'SELECT `id`, `title_category`, `symbol`
    FROM categories';
    $result_categories = mysqli_query($config_sql, $sql);
    $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);

    $page_content = include_template('inc/login-page.php', [
        'categories' => $categories,
        'errors' => $errors,
        'form_error' => $form_error,
        'user' => $user,
        'error_password_verify' => $error_password_verify
    ]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeti Cave'
]);
print($layout_content);
