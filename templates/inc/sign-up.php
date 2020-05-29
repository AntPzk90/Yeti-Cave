<main>
    <nav class="nav">
    <ul class="nav__list container">
        <li class="nav__item">
        <a href="all-lots.html">Доски и лыжи</a>
        </li>
        <li class="nav__item">
        <a href="all-lots.html">Крепления</a>
        </li>
        <li class="nav__item">
        <a href="all-lots.html">Ботинки</a>
        </li>
        <li class="nav__item">
        <a href="all-lots.html">Одежда</a>
        </li>
        <li class="nav__item">
        <a href="all-lots.html">Инструменты</a>
        </li>
        <li class="nav__item">
        <a href="all-lots.html">Разное</a>
        </li>
    </ul>
    </nav>
    <form class="form container <?=$form_error ? 'form--invalid': ''; ?>" action="registration.php" method="post" autocomplete="off">
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item <?=$errors['email'] ? 'form__item--invalid': ''; ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$new_user_value['email']?>">
        <span class="form__error">Введите корректный e-mail</span>
    </div>
    <div class="form__item <?=$errors['password'] ? 'form__item--invalid': ''; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error">Введите пароль</span>
    </div>
    <div class="form__item <?=$errors['name'] ? 'form__item--invalid': ''; ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=$new_user_value['name']?>">
        <span class="form__error">Введите имя</span>
    </div>
    <div class="form__item <?=$errors['message'] ? 'form__item--invalid': ''; ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться" value="<?=$new_user_value['message']?>"></textarea>
        <span class="form__error">Напишите как с вами связаться</span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
</main>
