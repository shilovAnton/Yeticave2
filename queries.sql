INSERT INTO categories
    (category_name, character_code)
VALUES ('Доски и лыжи', 'boards'),
       ('Крепления', 'attachment'),
       ('Ботинки', 'boots'),
       ('Одежда', 'clothing'),
       ('Инструменты', 'tools'),
       ('Разное', 'other');

INSERT INTO users
    (user_name, email, passport, contact_inf, tel)
VALUES ('Anton', 'Anton@gmail.com', '123456', 'sdddfgdfgd', '89502631889'),
       ('Ivan', 'ivan@mail.com', '123456', 'fdgfg', '89502631889'),
       ('Alexandr', 'alexandr@jandex.com', '123456', 'dgdf', '89502631889'),
       ('Andrey', 'Andrey@gmail.com', '123456', 'dfgfg', '89502631889'),
       ('Sergey', 'sergey@mail.com', '123456', 'dfgfg', '89502631889'),
       ('Pavel', 'pavel@mail.com,123456', '123456', 'bcvbgchzxcz', '89502631889');

INSERT INTO lots
(author_id, lot_name, category_id, description_lot, date_end, initial_rate, rate_step, img)
VALUES (1, '2014 Rossignol District Snowboard', 1, 'dfgdfgdfgdfgdf fgdg dfg', '2021-03-15', 10999, 1000, 'img/lot-1.jpg'),
       (2, 'DC Ply Mens 2016/2017 Snowboard', 2, 'dfgdfgdfgdfgdf fgdg dfg', '2021-09-11', 159999, 2000, 'img/lot-2.jpg'),
       (3, 'Крепления Union Contact Pro 2015 года размер L/XL', 3, 'dfgdfgdfgdfgdf fgdg dfg', '2021-08-12', 8000, 5000, 'img/lot-3.jpg'),
       (4, 'Ботинки для сноуборда DC Mutiny Charocal', 4, 'dfgdfgdfgdfgdf fgdg dfg', '2021-07-11', 10999, 1500, 'img/lot-4.jpg'),
       (5, 'Куртка для сноуборда DC Mutiny Charocal', 5, 'dfgdfgdfgdfgdf fgdg dfg', '2021-06-11', 7500, 300, 'img/lot-5.jpg'),
       (6, 'Маска Oakley Canopy', 6, 'dfgdfgdfgdfgdf fgdg dfg', '2021-10-09', 5400, 500, 'img/lot-6.jpg');

INSERT INTO rates
    (lot_id,author_id,rate)
VALUES
    (1,4,5000),
    (5,1,10000),
    (6,6,20000),
    (6,5,30000),
    (3,3,5000),
    (2,2,6000);

-- Получить все категории
SELECT category_name FROM categories;

-- получение последних открытых лотов
SELECT date_add, lot_name, initial_rate, img, MAX(rate) as max_rate, category_name
FROM lots l
         LEFT JOIN rates r
                   on l.id = r.lot_id
         LEFT JOIN categories c on c.id = l.category_id
WHERE NOW() < date_end
GROUP BY l.lot_name, l.date_add, l.initial_rate, l.img, c.category_name
ORDER BY l.date_add DESC
LIMIT 6;






















