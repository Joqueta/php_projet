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
<link rel="stylesheet" type="text/css" href="../css/stylesheet_login.css">
<link rel="stylesheet" type="text/css" href="../css/stylesheet_gererutilisateurs.css">
    <title>Administration</title>
</head>
<body>
    <?php 
        include "../includes/navbar.php";
        echo createHeader();
    ?>
    <h1>Panneur d'administration</h2>
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
</body>