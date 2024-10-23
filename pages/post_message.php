<?php
include('../db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $message = $_POST['message'];

    $stmt = $pdo->prepare("INSERT INTO publications (user_id, message, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$_SESSION['user_id'], $message]);

    header("Location: home.php");
    exit;
} else {
    header("Location: home.php");
    exit;
}
?>

