<?php
require_once('functions.php');
require_once('config.php');
// проверка авторизации пользователя
if (!$config_sql) {
    $page_content = include_template('inc/404.php', []);
} else {
    if(isset($_SESSION['user'])) {
        $user_auth = $_SESSION['user'];
    } else {
        $user_auth = null;
    }
    // запрос на получение категорий
    $sql = 'SELECT `id`, `title_category`, `symbol`
    FROM categories';
    $result_categories = mysqli_query($config_sql, $sql);
    $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
    // код для обработки формы поиска
    $search = $_GET['search'] ?? '';

    if ($search) {
        // запрос полнотекстового поиска
        $sql = "SELECT * FROM lots l JOIN categories c ON l.id_category = c.id WHERE MATCH(title_lot, dscr) AGAINST(?)";
        $stmt = db_get_prepare_stmt($config_sql, $sql, [$search]);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    $page_content = include_template('inc/search-page.php', [
        'items' => $items,
        'categories' => $categories,
        'search_word' => $search,
    ]);
}
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeti Cave',
    'user_auth' => $user_auth
]);
print($layout_content);
