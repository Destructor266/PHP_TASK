<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once __DIR__ . '/./controller/session.php';
if ((isset($_POST['username'])) && (isset($_POST['pwd']))) {
    $session = new Session($_POST['username'], $_POST['pwd']);
    if (!$session->startSession()) {
        header("Location: error_autoritzacio.php");
    }
}
?>