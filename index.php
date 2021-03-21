<?php

require_once('helpers.php');

$is_auth = random_int(0, 1);

// Функция которая выполняет соединение с БД, и возвращает объект с параметрами БД
$link =  mysqli_connect('localhost','mysql','mysql','yeticave');
if ($link == false){
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
}
else {
    //Запрос на получение категорий
    $inquiry = 'SELECT category_name, character_code FROM categories;';
    $result = mysqli_query($link, $inquiry);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //Запрос на получение последних открытых лотов
    $inquiry = 'SELECT date_add, date_end, lot_name, initial_rate, img, MAX(rate) as max_rate, category_name
FROM lots l
         LEFT JOIN rates r
                   on l.id = r.lot_id
         LEFT JOIN categories c on c.id = l.category_id
WHERE NOW() < date_end
GROUP BY l.lot_name, l.date_add, l.date_end, l.initial_rate, l.img, c.category_name
ORDER BY l.date_add DESC
LIMIT 6;';
    $result = mysqli_query($link, $inquiry);
    $goods = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Подключение главной страницы
$main = include_template(
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
        'content' => $main,
        'title' => 'Главная страница',
        'user_name' => 'Антон',
        'is_auth' => $is_auth,
        'categories' => $categories,
    ]
);

print($layout);
