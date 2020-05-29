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
    <form class="form container <?=$form_error ? 'form--invalid': ''; ?>" action="login.php" method="post">
        <h2>Вход</h2>
        <div class="form__item <?=$errors['email'] ? 'form__item--invalid': ''; ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$user['email']?>">
        <span class="form__error">Введите e-mail</span>
        </div>
        <div class="form__item form__item--last <?=$errors['password'] || $error_password_verify ? 'form__item--invalid': ''; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="text" name="password" placeholder="Введите пароль">
        <span class="form__error">
            <?php if($error_password_verify): ?>
                Не правильный пароль
            <?php else : ?>
                Введите пароль
            <?php endif ?>
        </span>

        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>
