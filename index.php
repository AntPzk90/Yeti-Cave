<?php
require_once('functions.php');
require_once('data.php');
require_once('config.php');
$page_content = include_template('inc/main.php', [
    'items' => $items,
    'categories' => $categories,
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeti Cave'
]);
print($layout_content);
