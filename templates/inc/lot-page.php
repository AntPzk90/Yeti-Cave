<main class="container">
    <section class="lot-item container">
        <h2><?= $item['title_lot'] ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="static/<?= $item['img_path']; ?>" width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?= $item['title_category']; ?></span></p>
                <p class="lot-item__description"><?= $item['dscr']; ?></p>
            </div>
            <div class="lot-item__right">
                <?php if (isset($user_auth)) : ?>
                    <div class="lot-item__state">
                        <div class="lot-item__timer timer <?= get_time($item['dt_fin'])['hours'] < 1 ? 'timer--finishing' : ''; ?>">
                            <?= get_time($item['dt_fin'])['hours']; ?>
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost"><?= $max_price ?></span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?= get_price($item['step']); ?>р</span>
                            </div>
                        </div>
                        <form class="lot-item__form" action="lot.php?id=<?= $id ?>" method="post" autocomplete="off">
                            <p class="lot-item__form-item form__item <?= $error ? 'form__item--invalid' : ''; ?>">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="text" name="cost" placeholder="<?= $bid; ?>" value="<?= $bid; ?>">
                                <span class="form__error">Введите ставку, не меньше минимальной</span>
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                    </div>
                <?php endif ?>
                <div class="history">
                    <h3>История ставок (<span><?= count($bids) ?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($bids as $key => $bid) : ?>
                            <tr class="history__item">
                                <td class="history__name">
                                    <?= $bid['name_user']; ?>
                                </td>
                                <td class="history__price">
                                    <?= get_price($bid['price_bid']) ?> р
                                </td>
                                <td class="history__time">
                                    <?= abs(get_time($bid['dt_add'])['minutes']) >= 60
                                        ? date('d.m.y', strtotime($bid['dt_add']))
                                        . ' в ' . date('H:i', strtotime($bid['dt_add']))
                                        :  abs(get_time($bid['dt_add'])['minutes'])
                                        . ' минут назад'; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
