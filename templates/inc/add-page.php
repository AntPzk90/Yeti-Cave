<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category) : ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?= $category['title_category'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form form--add-lot container <?= $form_error ? 'form--invalid' : '' ?>" action="add.php" method="post" enctype="multipart/form-data">
        <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item <?= $errors['name'] ? 'form__item--invalid' : '' ?>">
                <!-- form__item--invalid -->
                <label for="lot-name">Наименование <sup>*</sup></label>
                <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value=<?= $lot_value['lot-name'] ?>>
                <span class="form__error">Введите наименование лота</span>
            </div>
            <div class="form__item <?= $errors['category'] ? 'form__item--invalid' : '' ?>">
                <label for="category">Категория <sup>*</sup></label>
                <select id="category" name="category">
                    <option>Выберите категорию</option>
                    <?php foreach ($categories as $category) : ?>
                        <option <?= $category['title_category'] == $lot_value['category'] ? 'selected' : ''; ?>><?= $category['title_category'] ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form__error">Выберите категорию</span>
            </div>
        </div>
        <div class="form__item form__item--wide <?= $errors['message'] ? 'form__item--invalid' : '' ?>">
            <label for="message">Описание <sup>*</sup></label>
            <textarea id="message" name="message" placeholder="Напишите описание лота" value=<?= $lot_value['message'] ?>></textarea>
            <span class="form__error">Напишите описание лота</span>
        </div>
        <div class="form__item form__item--file <?= $errors['file_type'] ? 'form__item--invalid' : ''; ?>">
            <label>Изображение <sup>*</sup></label>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="lot-img" value="" name="lot-image">
                <label for="lot-img">
                    Добавить
                </label>
            </div>
        </div>
        <div class="form__container-three">
            <div class="form__item form__item--small <?= $errors['rate'] ? 'form__item--invalid' : '' ?>">
                <label for="lot-rate">Начальная цена <sup>*</sup></label>
                <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value=<?= $lot_value['lot-rate'] ?>>
                <span class="form__error">Введите начальную цену в нужном формате</span>
            </div>
            <div class="form__item form__item--small <?= $errors['step'] ? 'form__item--invalid' : '' ?>">
                <label for="lot-step">Шаг ставки <sup>*</sup></label>
                <input id="lot-step" type="text" name="lot-step" placeholder="0" value=<?= $lot_value['lot-step'] ?>>
                <span class="form__error">Введите шаг ставки в нужном формате</span>
            </div>
            <div class="form__item form__item--small <?= $errors['date'] ? 'form__item--invalid' : '' ?>">
                <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
                <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value=<?= $lot_value['lot-date'] ?>>
                <span class="form__error">Введите дату завершения торгов</span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
