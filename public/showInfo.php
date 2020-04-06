<?php
session_start();
require '../libs/db.php';
$DB = new DataBase();
if (isset($_SESSION['db_error'])) {
    echo 'Ошибка подключения к БД';
    unset($_SESSION['db_error']);
    die();
}
$report = $DB->getReportById($_GET['id']);
if ($report == false) {
    header('Location: accessError.php');
    die();
}
require '../libs/checkAccess.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="media/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Конференция</title>
</head>

<body>
    <?php require '../pages/header.php' ?>

    <div class="forms">
        <div class="infoBlock">
            <span><strong>Название: </strong></span>
            <span><?= $report['title']; ?></span>
        </div>
        <div class="infoBlock">
            <span><strong>О авторе: </strong></span>
            <span><?= $report['short_infouser']; ?></span>
        </div>
        <div class="infoBlock">
            <span><strong>Категория: </strong></span>
            <span><?= $report['category']; ?></span>
        </div>
        <div class="infoBlock">
            <span><strong>О докладе: </strong></span>
            <span><?= $report['short_inforeport']; ?></span>
        </div>
        <div class="infoBlock">
            <a href="actions/downloadfile.php?name=<?= $report['text']; ?>">Речь</a>
            <a href="actions/downloadfile.php?name=<?= $report['presentation']; ?>">Презентация</a>
        </div>
    </div>
</body>

</html>