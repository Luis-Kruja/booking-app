<?php
// Handle logout
session_start();

global $conn;
include 'config/db_connection.php';

if (isset($_COOKIE['remember_me'])) {
    $stmt = $conn->prepare("DELETE FROM sessions WHERE remember_token = ?");
    $stmt->bind_param("s", $_COOKIE['remember_me']);
    $stmt->execute();

    setcookie("remember_token", "", time() - 3600, "/", "", false, true);
}

session_destroy();
header('Location: login.php');
exit;
