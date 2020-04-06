<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/../libs/checkAccess.php';
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
