<?php
session_start();
require '../config/categories.php';
require '../libs/saveUserFormsData.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="media/styles.css">
    <title>Конференция</title>
</head>

<body>
    <?php require '../pages/header.php'; ?>
    <div class="forms">
        <?php if (isset($_SESSION['_errors'])) : ?>
            <ul>
                <?php foreach ($_SESSION['_errors'] as $error) : ?>
                    <li style="color: red"><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <?php unset($_SESSION['_errors']); ?>
        <?php endif; ?>
        <form action="actions/reportAddValid.php" method="post" enctype="multipart/form-data">
            <div class="inFormsBlock">
                <strong>Название доклада</strong>
                <input type="text" name="title" value="<?= @$_SESSION['reportAdd_data']['title'] ?>">
                <div class="inFormsBlock">
                    <strong>О вас</strong>
                    <textarea name="aboutUser" cols="30" rows="10"><?= @$_SESSION['reportAdd_data']['aboutUser'] ?></textarea>
                </div>
                <div class="inFormsBlock">
                    <strong>Категория</strong>
                    <select name="category">
                        <?php foreach ($categories as $elem) : ?>
                            <option value="<?= $elem ?>"><?= $elem ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="inFormsBlock">
                    <strong>О докладе</strong>
                    <textarea name="aboutReport" cols="30" rows="10"><?= @$_SESSION['reportAdd_data']['aboutReport'] ?></textarea>
                </div>
                <div class="inFormsBlock">
                    <strong>Речь выступления</strong>
                    <input type="file" name="speech" placeholder="doc,docx,pdf , не более 10 мб">
                    <strong>Презентация</strong>
                    <input type="file" name="presentation" placeholder="ppt,pptx,pdf , не более 30 мб">
                </div>
                <button type="submit" name="button" class="btn btn-info">
                    Добавить
                </button>
        </form>
    </div>
</body>

</html>