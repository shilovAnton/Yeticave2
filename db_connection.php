<?php

// Функция которая выполняет соединение с БД, и возвращает объект с параметрами БД
$link =  mysqli_connect('localhost','mysql','mysql','yeticave');
if ($link === false){
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    exit();
}

//Запрос на получение категорий
$query = 'SELECT category_name, character_code FROM categories;';
$result = mysqli_query($link, $query);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
