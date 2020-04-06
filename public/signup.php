<?php
session_start();
if (isset($_SESSION['id'])) {
    header('Location: ../index.php');
    die();
}
require '../libs/saveUserFormsData.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="media/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Конференция блина</title>
</head>

<body>
    <?php require '../pages/header.php' ?>
    <div class="forms">
        <?php if (isset($_SESSION['_errors'])) : ?>
            <ul>
                <?php foreach ($_SESSION['_errors'] as $error) : ?>
                    <li style="color: red"><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <?php unset($_SESSION['_errors']); ?>
        <?php endif; ?>
        <form action="actions/signupValid.php" method="post">
            <div class="inFormsBlock">
                <strong>Ваш email</strong>
                <input type="email" name="email" value="<?= @$_SESSION['signup_data']['email'] ?>">
            </div>
            <div class="inFormsBlock">
                <strong>Ваше имя</strong>
                <input type="text" name="name" value="<?= @$_SESSION['signup_data']['name'] ?>">
            </div>
            <div class="inFormsBlock">
                <strong>Пароль</strong>
                <input type="password" name="password" value="<?= @$_SESSION['signup_data']['password'] ?>">
            </div>
            <div class="inFormsBlock">
                <strong>Повторите ваш пароль</strong>
                <input type="password" name="password2" value="<?= @$_SESSION['signup_data']['password2'] ?>">
            </div>
            <div class="inFormsBlock">
                <strong>Я согласен на обработку персональных данных</strong>
                <input type="checkbox" name="userAccept">
            </div>
            <div class="inFormsBlock">
                <button type="submit" name="button" class="btn btn-info">
                    Зарегистрироваться
                </button>
            </div>
        </form>
    </div>
</body>

</html>