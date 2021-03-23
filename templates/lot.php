<pre><?= var_dump($lot); ?></pre>
<section class="lot-item container">
    <h2><?= $lot['lot_name']; ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= $lot['img']; ?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot['category_name']; ?></span></p>
            <p class="lot-item__description"><?= $lot['description_lot']; ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="lot-item__timer timer<?php
                if (get_dt_range($lot['date_end'])[1] === true): ?> timer--finishing<?php
                endif ?>">
                    <?= get_dt_range($lot['date_end'])[0]; ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= format_price($lot['max_rate']); ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= format_price($lot['max_rate'] + $lot['rate_step']); ?></span>
                    </div>
                </div>
                <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post" autocomplete="off">
                    <p class="lot-item__form-item form__item form__item--invalid">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost"
                               placeholder="<?= format_price($lot['max_rate'] + $lot['rate_step']); ?>">
                        <span class="form__error">Введите Вашу ставку</span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <div class="history">
                <h3>История ставок (<span><?= $lot['count']; ?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($rates as $rate): ?>
                    <tr class="history__item">
                        <td class="history__name"><?= $rate['user_name']; ?></td>
                        <td class="history__price"><?= format_price($rate['rate']); ?></td>
                        <td class="history__time"><?= $rate['date_rate']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>

