<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/../libs/db.php';

$db = new DataBase();
if ($_SESSION['db_error']) {
    echo 'Ошибка доступа к БД';
    die();
}

if ($_SESSION['access_level'] != 'admin') {
    $reportUser_Id = $db->getReportIdByName($_GET['name']);
    if ($reportUser_Id != $_SESSION['id']) {
        header('Location: ../accessError.php');
        die();
    }
}

$file = $_SERVER['DOCUMENT_ROOT'] . '/../usersfiles/' . $_GET['name'];
if (!file_exists($file)) {
    header('Location: ../accessError.php');
    die();
}

if (stristr($_GET['name'], 'present')) {
    $newfileName = 'present.' . end(explode('.', $_GET['name']));
} else {
    $newfileName = 'speech.' . end(explode('.', $_GET['name']));
}

header("Content-Type: application/octet-stream");
header("Accept-Ranges: bytes");
header("Content-Length: " . filesize($file));
header("Content-Disposition: attachment; filename=" . $newfileName);
readfile($file);
