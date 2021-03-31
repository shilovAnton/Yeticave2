<?php

require_once('helpers.php');
require_once('db_connection.php');

$is_auth = random_int(0, 1);

var_dump($_POST);


// Подключение главной страницы
    $content = include_template(
        'add.php',
        [
            'categories' => $categories,
        ]
    );

// Передача переменных, и контента - лейауту;
    $layout = include_template(
        'layout.php',
        [
            'content' => $content,
            'title' => 'Добавление лота',
            'user_name' => 'Антон',
            'is_auth' => $is_auth,
            'categories' => $categories,
            'nav' => true,
        ]
    );

    print($layout);


