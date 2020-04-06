<?php
if (isset($_SESSION['id'])) {
    if ($_SESSION['access_level'] != 'admin') {
        if ($_SESSION['id'] != $report['user_id']) {
            header( 'Location: ../accessError.php');
            die();
        }
    }
} else {
    header('Location: login.php');
}
