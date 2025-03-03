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
?>

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
    <h1>Panneau d'administration</h1>
    <p>Bienvenue, <?php echo $_SESSION["username"] ?> !</p>
    <a href="dashboard.php">Retour au tableau de bord</a>
    <a href="gerer_utilisateurs.php">Gérer les utilisateurs</a>
    <a href="categories.php">Gérer les catégories</a>
    <a href="users_taks.php">Gérer les tâches</a>
    <a href="comments.php">Gérer les commentaires</a>
    <a href="attachments.php">Gérer les pièces jointes</a>
    <a href="logout.php">Déconnexion</a>


<?php
// Afficher les messages de succès ou d'erreur
if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']);
} elseif (isset($_SESSION['error'])) {
    echo "<div class='alert alert-error'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}
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
                    <form action='../../includes/admin_functions.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='user_id' value='{$user['id']}'>
                        <button type='submit' name='promouvoir_admin'>Promouvoir admin</button>
                    </form>
                    <form action='../../includes/admin_functions.php' method='POST' style='display:inline;'
                    onsubmit='return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');'>
                        <input type='hidden' name='user_id' value='{$user['id']}'>
                        <button type='submit' name='delete_user' style='color:red;'>Supprimer</button>
                    </form>
                </td>
              </tr>";
    }
    echo '</table>';
?>
</body>
</html>