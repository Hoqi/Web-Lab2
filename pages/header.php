<div class="header">
    <a href="index.php" class="confTitle">Конференция "Я и город"</a>
    <div class="auth">
        <?php if (!isset($_SESSION['id'])) : ?>
            <a href="signup.php" class="btn btn-primary">Зарегистрироваться</a>
            <a href="login.php" class="btn btn-primary">Логин</a>
        <?php else : ?>
            <a href="actions/logout.php" class="btn btn-primary">Выход</a>
        <?php endif; ?>
    </div>
    <?php
    $Hello = $_SESSION['name'];
    if (!isset($Hello))
        $Hello = 'Незнакомец';
    ?>
    <span class="sayHello">Привет, <?= $Hello ?></span>
</div>