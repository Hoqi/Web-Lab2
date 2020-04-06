<?php
session_start();
$data = $_POST;
$_SESSION['login_data'] = $_POST;
if (isset($data['button'])) {
    require $_SERVER['DOCUMENT_ROOT'] . '/../libs/validation/loginvalidation.php';
    $valid = new loginValidation($data);
    $valid->validation();
}
if (isset($_SESSION['_errors'])) {
    header('Location: ../login.php');
} else {
    unset($_SESSION['_data']);
    header('Location: ../index.php');
}
die();
