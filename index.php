<?php

$title = 'Главная';
$is_auth = rand(0, 1);
$user_name = 'Антон'; // укажите здесь ваше имя

$categories = [
    'Доски и лыжи',
    'Крепления',
    'Ботинки',
    'Одежда',
    'Инструменты',
    'Разное',
];

$goods = [
    [
        'название' => '2014 Rossignol District Snowboard',
        'категория' => 'Доски и лыжи',
        'цена' => 10999,
        'картинка' => 'img/lot-1.jpg',
    ],
    [
        'название' => 'DC Ply Mens 2016/2017 Snowboard',
        'категория' => 'Доски и лыжи',
        'цена' => 159999,
        'картинка' => 'img/lot-2.jpg',
    ],
    [
        'название' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'категория' => 'Крепления',
        'цена' => 8000,
        'картинка' => 'img/lot-3.jpg',
    ],
    [
        'название' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'категория' => 'Ботинки',
        'цена' => 10999,
        'картинка' => 'img/lot-4.jpg',
    ],
    [
        'название' => 'Куртка для сноуборда DC Mutiny Charocal',
        'категория' => 'Одежда',
        'цена' => 7500,
        'картинка' => 'img/lot-5.jpg',
    ],
    [
        'название' => 'Маска Oakley Canopy',
        'категория' => 'Разное',
        'цена' => 5400,
        'картинка' => 'img/lot-6.jpg',
    ],
];

/**
 * форматирование цены
 * @param int $price Цена введённая пользователем
 * @return string Отформатированная цена
 */
function format_price($price)
{
    $price_format = number_format($price, 0, '.', ' ');

    return $price_format . ' ₽';
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = [])
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data, EXTR_OVERWRITE);
    require $name;

    $result = ob_get_clean();

    return $result;
}

// Подключение главной страницы
$main = include_template(
    'main.php',
    [
        'categories' => $categories,
        'goods' => $goods,
    ]
);

// Передача переменных, и контента лейауту
$layout = include_template(
    'layout.php',
    [
        'content' => $main,
        'title' => $title,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'categories' => $categories,
    ]
);

print($layout);
