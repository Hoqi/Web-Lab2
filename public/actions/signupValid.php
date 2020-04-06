<?php
session_start();
$data = $_POST;
$_SESSION['signup_data'] = $_POST;
if (!isset($data['userAccept'])) {
    $_SESSION['_errors'][] = 'Вы не дали согласия на обработку данных';
} else {
    require $_SERVER['DOCUMENT_ROOT'] . '/../libs/validation/signupvalidation.php';
    $valid = new signUpValidation($data, $validSettings);
    $valid->validation();
}
if (isset($_SESSION['_errors'])) {
    header('Location: ../signup.php');
} else {
    unset($_SESSION['signup_data']);
    header('Location: ../index.php');
}
die();
