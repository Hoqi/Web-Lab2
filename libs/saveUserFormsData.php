<?php
$currentPage = basename($_SERVER['REQUEST_URI']);

function clearData(array $names): void
{
    foreach ($names as $name) {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }
}
$deleteData;
if ($currentPage == 'login.php') {
    $deleteData = ['signup_data', 'reportAdd_data'];
} else if ($currentPage == 'signup.php') {
    $deleteData = ['login_data', 'reportAdd_data'];
} else if ($currentPage == 'reportAdd.php') {
    $deleteData = ['login_data', 'signup_data'];
} else {
    $deleteData = ['login_data', 'signup_data', 'reportAdd_data'];
}
clearData($deleteData);