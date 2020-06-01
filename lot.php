<?php
require_once('functions.php');
require_once('config.php');
// проверка авторизации пользователя
if (isset($_SESSION['user'])) {
    $user_auth = $_SESSION['user'];
} else {
    $user_auth = null;
}
// получаем id лота
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $page_content = include_template('inc/404.php', []);
}

if (!$config_sql) {
    $page_content = include_template('inc/404.php', []);
} else {
    // запрос на получение категории из бд
    $sql = 'SELECT `id`, `title_category`, `symbol`
    FROM categories';
    $result_categories = mysqli_query($config_sql, $sql);
    $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
    //запрос на получение лотов
    $sql = 'SELECT * FROM lots l
    JOIN categories c
    ON l.id_category = c.id
    WHERE l.id = ' . $id . '';

    $result_items = mysqli_query($config_sql, $sql);
    $lot_item = mysqli_fetch_all($result_items, MYSQLI_ASSOC);
    $lot = $lot_item[0];
    // запрос на получение ставок
    $sql = 'SELECT b.dt_add, b.price_bid, b.id_user, users.name_user FROM bids b
    JOIN users ON b.id_user = users.id
    WHERE b.id_lot = ' . $id . '';
    $result = mysqli_query($config_sql, $sql);
    $bids = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // поиск максимальной цены
    $sql = "SELECT price_bid FROM `bids` WHERE `id_lot`='" . $id . "'";
    $result = mysqli_query($config_sql, $sql);
    $bid_price = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $max_price = max($bid_price)['price_bid'];

    // валидация формы ставки
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST)) {
            $bid = $_POST;
            $error = false;

            if ($bid['cost'] < $lot['step'] || empty($bid['cost'])) {
                $error = true;
            } else {
                $total_price = $max_price + $bid['cost'];
                $sql = 'INSERT INTO bids (price_bid, id_lot, id_user)
                VALUES ( ?, ?, ?)';
                $stmt = db_get_prepare_stmt($config_sql, $sql, [$total_price, $lot['id'], $user_auth['id']]);
                $result = mysqli_stmt_execute($stmt);

                if ($sql) {
                    print('добавлено');
                }
            }
        }
    }

    $page_content = include_template('inc/lot-page.php', [
        'item' => $lot,
        'user_auth' => $user_auth,
        'id' => $id,
        'error' => $error,
        'bid' => $bid['cost'],
        'bids' => $bids,
        'max_price' => $max_price
    ]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeti Cave',
    'user_auth' => $user_auth
]);
print($layout_content);
