<?php
session_start();
$uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/../usersfiles/';
require $_SERVER['DOCUMENT_ROOT'] . '/../libs/validation/reportvalidation.php';
$_SESSION['reportAdd_data'] = $_POST;
$valid = new reportValidation($_POST, $_FILES);
$newPath = $valid->validation();
if (isset($_SESSION['_errors'])) {
    header('Location: ../reportAdd.php');
} else {
    foreach ($newPath as $key => $value) {
        move_uploaded_file($_FILES[$key]['tmp_name'], $uploaddir . $value);
    }
    header('Location: ../index.php');
}
