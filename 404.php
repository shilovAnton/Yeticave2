<?php

require_once('helpers.php');
require_once('db_connection.php');

$is_auth = random_int(0, 1);

// Подключение главной страницы
$content = include_template(
    '404.php',
    []
);

// Передача переменных, и контента - лейауту;
$layout = include_template(
    'layout.php',
    [
        'content' => $content,
        'title' => '404',
        'user_name' => 'Антон',
        'is_auth' => $is_auth,
        'categories' => $categories,
        'nav' => true,
    ]
);

print($layout);
