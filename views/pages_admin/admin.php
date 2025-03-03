<?php 
require_once '../../includes/db.php';   
require_once '../../includes/admin_functions.php';
require_once '../../includes/user_functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
};

// if (!isAdmin()){
//     header('Location: ../index.php');
//     exit;
// }
// ?>

<!DOCTYPE html>
<html>
<head>  
<link rel="stylesheet" type="text/css" href="../css/stylesheet_login.css">
    <title>Administration</title>
</head>
<body>
    <?php 
        include "../../includes/navbar.php";
        echo createHeader();
    ?>
    <h1>Panneur d'administration</h2>
    <p>Bienvenue, <?php echo $_SESSION["username"] ?> !</p>
    <a href="../dashboard.php">Retour au tableau de bord</a>
    <a href="gerer_utilisateurs.php">Gérer les utilisateurs</a>
    <a href="categories.php">Gérer les catégories</a>
    <a href="tasks.php">Gérer les tâches</a>
    <a href="comments.php">Gérer les commentaires</a>
    <a href="attachments.php">Gérer les pièces jointes</a>
    <a href="logout.php">Déconnexion</a>
</body>