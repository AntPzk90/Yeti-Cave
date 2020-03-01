<?php
include_once 'helpers.php';
include_once 'data.php';
include_once 'functions.php';

$page_content = include_template('inc/main.php', [
   'categories' => $categories,
    'cards' => $cards
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Главная страница',
    'user_name' => 'Виктор',
    'is_auth' => $is_auth,
    'categories' => $categories
]);

print($layout_content);

