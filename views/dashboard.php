<?php
require_once '../includes/db.php';
require_once '../includes/user_functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {  
    header("Location: login.php");
    exit();
}
// Ajouter log out
$pdo = getDBConnection();
$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("SELECT tasks.id, tasks.title, tasks.description, tasks.status, categories.name AS category 
                       FROM tasks 
                       LEFT JOIN categories ON tasks.category_id = categories.id
                       WHERE tasks.user_id = :user_id");
$stmt->execute([":user_id" => $user_id]);
$tasks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
</head>
<body>
    <h2>Vos tâches</h2>
    <a href="add_task.php">➕ Ajouter une tâche</a>
    <table border="1">
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Statut</th>
            <th>Catégorie</th>
        </tr>
        <?php foreach ($tasks as $task) : ?>
            <tr>
                <td><?= htmlspecialchars($task["title"]) ?></td>
                <td><?= htmlspecialchars($task["description"]) ?></td>
                <td><?= htmlspecialchars($task["status"]) ?></td>
                <td><?= htmlspecialchars($task["category"] ?? "Aucune") ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>