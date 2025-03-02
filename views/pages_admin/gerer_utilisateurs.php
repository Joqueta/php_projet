<?php 
require_once '../includes/db.php';
require_once '../includes/admin_functions.php';
require_once '../includes/user_functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_start();

if (!isAdmin()){
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/stylesheet_login.css">
    <title>Administration</title>
</head>
<body>
    <?php 
        include "../includes/navbar.php";
        echo createHeader();
    ?>
    <h1>Panneur d'administration</h2>
    <p>Bienvenue, <?php echo $_SESSION["username"] ?> !</p>
    <a href="dashboard.php">Retour au tableau de bord</a>
    <a href="gerer_user.php">Gérer les utilisateurs</a>
    <a href="categories.php">Gérer les catégories</a>
    <a href="tasks.php">Gérer les tâches</a>
    <a href="comments.php">Gérer les commentaires</a>
    <a href="attachments.php">Gérer les pièces jointes</a>
    <a href="logout.php">Déconnexion</a>
</body>

<?php
$pdo = getDBConnection();
$stmt = $pdo->query("SELECT id, username, email, role FROM users");
$users = $stmt->fetchAll();

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Actions</th></tr>";
foreach ($users as $user) {
    echo "<tr>
            <td>{$user['id']}</td>
            <td>{$user['username']}</td>
            <td>{$user['email']}</td>
            <td>{$user['role']}</td>
            <td>
                <a href='promote.php?id={$user['id']}'>Promouvoir admin</a> | 
                <a href='delete.php?id={$user['id']}'>Supprimer</a>
            </td>
          </tr>";
}
echo "</table>";
?>