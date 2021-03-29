<?php
/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_float($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []): string
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) { //Сообщает существует ли файл, и доступен ли файл для чтения;
        return $result;
    }

    ob_start(); //Включение буферизации вывода
    extract($data, EXTR_OVERWRITE); // Эта функция рассматривает ключи массива в качестве имён переменных,
    // а их значения - в качестве значений этих переменных.
    require $name;

    $result = ob_get_clean(); //Получить содержимое текущего буфера и удалить его

    return $result;
}

/**
 * форматирует цену, добавляет пробел и знак '₽'
 * @param int $price Цена введённая пользователем
 * @return string Отформатированная цена
 */
function format_price($price): string
{
    $price_format = number_format($price, 0, '.', ' ');

    return $price_format . ' ₽';
}

/**
 * Таймер аукциона, рассчитывает остаток времени до окончания торгов в формате: Часы:Минуты
 * @param string $date_end Дата окончания
 * @return array Остаток часов и минут, и булево true если осталось менее часа
 */
function get_dt_range($date_end): array
{
    if (is_date_valid($date_end)) {
        $date_end_unit = strtotime($date_end);
        $now = time();
        if ($date_end_unit > $now) {
            $interval = $date_end_unit - $now;
            $hors = intdiv($interval, 3600);
            $min = intdiv(($interval % 3600), 60);
            if ($hors < 1) {
                $timer_finishing = true;
            } else {
                $timer_finishing = false;
            }
            if ($hors < 10) {
                $hors = '0' . $hors;
            }
            if ($min < 10) {
                $min = '0' . $min;
            }
        } else {
            $hors = '00';
            $min = '00';
            $timer_finishing = true;
        }
    }
    return [$hors.' : '.$min, $timer_finishing];
}

/**
 * Возвращает удобную, для восприятия, форму даты добавления ставок
 * @param $date_add string дата добавления ставки
 * @return string удобочитаемый вид записи
 * @throws Exception
 */
function rates_add($date_add): string
{
    $now = new DateTime('now', new DateTimeZone('Asia/Novosibirsk'));
    $add_object = new DateTime($date_add, new DateTimeZone('Asia/Novosibirsk'));
    $interval = $now->diff($add_object);
    if ((($interval->d < 1) and ($interval->h < 1)) and ($interval->m < 1)) {
        $add = $interval->i . ' ' . get_noun_plural_form($interval->i, 'минуту', 'минуты', 'минут') . ' назад';
        if ($interval->i < 2) {
            $add = 'Только что';
        }
    } else {
        if (($interval->m < 1) and ($interval->d < 1) and ($interval->h === 1) and ($interval->i < 2)) {
            $add = 'Час назад';
        } else {
            $add = $add_object->format('d.m.y в H:i');
        }
    }
    return $add;
}
