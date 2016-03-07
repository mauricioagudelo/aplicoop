<?php
// we must never forget to start the session
session_start();

if ($_SESSION['image_is_logged_in'] == 'true') {

    header('Location: escriptori2.php');
    exit;

} else {
    header('Location: index.php');
    exit;
}

