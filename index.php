<?php
require_once('functions.php');
require_once('config.php');

if (!$config_sql) {
    $page_content = include_template('inc/404.php', []);
} else {
    // защита от sql-иньекций экранированием
    $test = mysqli_real_escape_string($config_sql, $_GET['search']);
    // запрос на получение категорий
    $sql = 'SELECT `id`, `title_category`, `symbol`
    FROM categories';
    $result_categories = mysqli_query($config_sql, $sql);
    $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);

    // запрос на получение лотов
    $sql = 'SELECT * FROM lots l
    JOIN categories c
    ON l.id_category = c.id';

    $result_items = mysqli_query($config_sql, $sql);
    $items = mysqli_fetch_all($result_items, MYSQLI_ASSOC);
    if ($result_categories && $result_items) {
        $page_content = include_template('inc/main.php', [
            'items' => $items,
            'categories' => $categories,
        ]);
    } else {
        $page_content = include_template('inc/404.php', []);
    }
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeti Cave'
]);
print($layout_content);
