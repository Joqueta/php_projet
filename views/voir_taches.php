<?php 
require_once '../includes/db.php';
require_once '../includes/admin_functions.php';
require_once '../includes/user_functions.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
};

 if (!isAdmin()){
     header('Location: index.php');
     exit;
 }
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/stylesheet_gerertaches.css">
    <title>Administration</title>
</head>
<body>
    <?php 
        include "../includes/navbar.php";
        echo createHeader();
        
        $stmt = $pdo->prepare("SELECT tasks.*, users.username FROM tasks INNER JOIN users ON tasks.user_id = users.id");
        $stmt->execute();
        $tasks = $stmt->fetchAll();
    ?>
    <h1>Panneau d'administration</h1>
    <p>Bienvenue, <?php echo $_SESSION["username"] ?> !</p>
    <nav class="admin-menu">
        <ul>
            <li><a href="dashboard.php">Tableau de bord</a></li>
            <li><a href="gerer_utilisateurs.php">Utilisateurs</a></li>
            <li><a href="voir_taches.php">Tâches</a></li>
            <li><a href="gerer_commentaires.php">Commentaires</a></li>
            <li><a href="attachments.php">Pièces jointes</a></li>
        </ul>
    </nav>
    <h2>Listes des tâches</h2>
    <table>
        <thead>
            <tr>
                <th>ID Tâche</th>
                <th>Utilisateur</th>
                <th>Description</th>
                <th>Date de Création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['id']); ?></td>
                    <td><?php echo htmlspecialchars($task['username']); ?></td>
                    <td><?php echo htmlspecialchars($task['description']); ?></td>
                    <td><?php echo htmlspecialchars($task['created_at']); ?></td>
                    <td>
                        <a href="add_taskUser.php" class="ajouter">Ajouter une Tâche</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>

</body>
</html>
