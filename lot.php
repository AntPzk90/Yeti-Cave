<?php
require_once('functions.php');
require_once('config.php');
// проверка авторизации пользователя
if(isset($_SESSION['user'])) {
    $user_auth = $_SESSION['user'];
} else {
    $user_auth = null;
}
// сделать проверки isset
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $page_content = include_template('inc/404.php', []);
}

if (!$config_sql) {
    $page_content = include_template('inc/404.php', []);
} else {
    $sql = 'SELECT `id`, `title_category`, `symbol`
    FROM categories';
    $result_categories = mysqli_query($config_sql, $sql);
    $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);

    $sql = 'SELECT * FROM lots l
    JOIN categories c
    ON l.id_category = c.id
    WHERE l.id = '. $id .'';

    $result_items = mysqli_query($config_sql, $sql);
    $lot_item = mysqli_fetch_all($result_items, MYSQLI_ASSOC);
    $page_content = include_template('inc/lot-page.php', [
        'item' => $lot_item[0],
        'user_auth' => $user_auth
    ]);
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeti Cave',
    'user_auth' => $user_auth
]);
print($layout_content);
