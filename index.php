<?php

require_once('helpers.php');
require_once('db_connection.php');

$is_auth = random_int(0, 1);

//Запрос на получение последних открытых лотов
$query = 'SELECT l.id, date_add, date_end, lot_name, initial_rate, img, MAX(rate) as max_rate, category_name
FROM lots l
         LEFT JOIN rates r
                   on l.id = r.lot_id
         LEFT JOIN categories c on c.id = l.category_id
WHERE NOW() < date_end
GROUP BY l.lot_name, l.date_add, l.date_end, l.initial_rate, l.img, c.category_name, l.id
ORDER BY l.date_add DESC
LIMIT 7;';
$result = mysqli_query($link, $query);
$goods = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Подключение главной страницы
$content = include_template(
    'main.php',
    [
        'categories' => $categories,
        'goods' => $goods,
    ]
);

// Передача переменных, и контента - лейауту;
$layout = include_template(
    'layout.php',
    [
        'content' => $content,
        'title' => 'Главная страница',
        'user_name' => 'Антон',
        'is_auth' => $is_auth,
        'categories' => $categories,
        'nav' => false,
    ]
);

print($layout);
