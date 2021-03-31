<?php

require_once('helpers.php');
require_once('db_connection.php');

$is_auth = random_int(0, 1);

$id = htmlspecialchars($_GET['id']);

if (isset($id)) {
    $query = 'SELECT l.id, l.author_id, l.date_end, l.lot_name, l.initial_rate, img, MAX(rate) as max_rate, COUNT(rate)
       as count, category_name, rate_step, description_lot
FROM lots l
         LEFT JOIN rates r
                   on l.id = r.lot_id
         LEFT JOIN categories c on c.id = l.category_id
WHERE l.id = ' . $id . ' AND  l.date_end > NOW()
GROUP BY  l.id, l.author_id, l.date_end, l.lot_name, l.initial_rate, img,category_name, rate_step, description_lot;';

    $result = mysqli_query($link, $query);
    $lot = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($lot['id'] === $id) {
        $query = 'SELECT rate, user_name, date_rate
FROM rates
        LEFT JOIN users u on rates.author_id = u.id
WHERE lot_id = ' . $id . '
ORDER BY date_rate DESC
LIMIT 12;';

        $result = mysqli_query($link, $query);
        $rates = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $content = include_template(
            'lot.php',
            [
                'lot' => $lot,
                'rates' => $rates,
            ]
        );

// Передача переменных, и контента - лейауту;
        $layout = include_template(
            'layout.php',
            [
                'content' => $content,
                'title' => $lot['lot_name'],
                'user_name' => 'Антон',
                'is_auth' => $is_auth,
                'categories' => $categories,
                'nav' => true,
            ]
        );

        print($layout);
    } else {
        header("Location: http://yeticave2/404.php");
    }
}
