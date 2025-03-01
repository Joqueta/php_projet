<?php
require_once '../includes/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task_id"])) {
    $task_id = $_POST["task_id"];
    $user_id = $_SESSION["user_id"];

    $pdo = getDBConnection();
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :task_id AND user_id = :user_id");
    $stmt->execute([":task_id" => $task_id, ":user_id" => $user_id]);

    header("Location: ../views/dashboard.php");
    exit();
} else {
    header("Location: ../views/dashboard.php");
    exit();
}
?>