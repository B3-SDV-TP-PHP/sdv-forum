<?php

require_once '../services/getData.php';

$user_id = $_COOKIE['token'] ?? null;

if ($user_id) {
    setcookie('token', '', time() - 3600, '/');
    header('Location: index.php');
    exit();
}
header('Location: index.php');

?>