<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['name']) || empty($_SESSION['name'])) {
    header('Location: login.php');
    exit;
}
?>