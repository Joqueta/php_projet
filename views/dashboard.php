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
$pdo = getDBConnection();
$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("SELECT tasks.id, tasks.title, tasks.description, tasks.importance, categories.name AS category, attachments.file_name, attachments.file_path 
                       FROM tasks 
                       LEFT JOIN categories ON tasks.category_id = categories.id
                       LEFT JOIN attachments ON tasks.id = attachments.task_id
                       WHERE tasks.user_id = :user_id");
$stmt->execute([":user_id" => $user_id]);
$tasks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/stylesheet_dashboard.css">
    <title>Tableau de bord</title>
</head>
<body>
    <?php 
        include "../includes/navbar.php";
        echo createHeader();
    ?>
    <h2>Vos tâches</h2>
    <a href="add_task.php">➕ Ajouter une tâche</a>
    <table border="1">
        <tr">
            <th>Titre</th>
            <th>Description</th>
            <th>Importance</th>
            <th>Catégorie</th>
            <th>Document</th>
            <th>Supprimer</th>
        </tr>
        <?php foreach ($tasks as $task) : ?>
            <tr>
                <td><?= htmlspecialchars($task["title"]) ?></td>
                <td><?= htmlspecialchars($task["description"]) ?></td>
                <td><?= htmlspecialchars($task["importance"]) ?></td>
                <td><?= htmlspecialchars($task["category"] ?? "Aucune") ?></td>
                <td>
                    <?php if (!empty($task["file_name"])) : ?>
                        <a href="<?= htmlspecialchars($task["file_path"]) ?>" download><?= htmlspecialchars($task["file_name"]) ?></a>
                    <?php else : ?>
                        Aucun document
                    <?php endif; ?>
                </td>
                <td>
                    <form action="../includes/delete_task.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');">
                        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                        <button type="submit">🗑️ Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>    
</body>
</html>