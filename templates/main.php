<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и
        горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <!--заполните этот список из массива категорий-->
        <?php
        foreach ($categories as $value): ?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?= $value; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <!--заполните этот список из массива с товарами-->
        <?php
        foreach ($goods as $values): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= $values['картинка']; ?>" width="350" height="260" alt="изображение товара">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $values['категория']; ?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?= $values['название']; ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= format_price($values['цена']); ?></span>
                        </div>
                        <div class="lot__timer timer<?php
                        if (get_dt_range($values['дата истечения'])[1] === true): ?> timer--finishing<?php endif ?>">
                            <?= get_dt_range($values['дата истечения'])[0]; ?>
                        </div>
                    </div>
                </div>
            </li>
        <?php
        endforeach; ?>
    </ul>
</section>
