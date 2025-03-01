<?php
require_once '../includes/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comment"])) {
    $comment = $_POST["comment"];
    $user_id = $_SESSION["user_id"];

    $pdo = getDBConnection();
    $stmt = $pdo->prepare("INSERT INTO comments (user_id, comment) VALUES (:user_id, :comment)");
    $stmt->execute([":user_id" => $user_id, ":comment" => $comment]);

    header("Location: ../views/index.php");
    exit();
} else {
    header("Location: ../views/index.php");
    exit();
}
?>