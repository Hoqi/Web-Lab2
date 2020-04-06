<?php
if (isset($_SESSION['id'])) {
    if ($_SESSION['access_level'] != 'admin') {
        if ($_SESSION['id'] != $report['user_id']) {
            header($_SERVER['DOCUMENT_ROOT'].'/accessError.php');
        }
    }
} else {
    header('Location: login.php');
}
