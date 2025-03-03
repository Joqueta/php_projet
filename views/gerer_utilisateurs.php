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
<link rel="stylesheet" type="text/css" href="../css/stylesheet_gererutilisateurs.css">
    <title>Administration</title>
</head>
<body>
    <?php 
        include "../includes/navbar.php";
        echo createHeader();
    ?>
    
    <h1>Panneau d'administration</h1>
    <p>Bienvenue, <?php echo $_SESSION["username"] ?> !</p>
    <nav class="admin-menu">
        <ul>
            <li><a href="dashboard.php">Tableau de bord</a></li>
            <li><a href="gerer_utilisateurs.php">Utilisateurs</a></li>
            <li><a href="voir_taches.php">Tâches</a></li>
            <li><a href="gerer_commentaires.php">Commentaires</a></li>
        </ul>
    </nav>


    <?php
        // Afficher les messages de succès ou d'erreur
        if (isset($_SESSION['success'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
            unset($_SESSION['success']);
        } elseif (isset($_SESSION['error'])) {
            echo "<div class='alert alert-error'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        $stmt = $pdo->prepare("SELECT id, username, email, role FROM users");
        $stmt->execute();
        $users = $stmt->fetchAll(); 
        ?>
    <h2>Gérer les utilisateurs</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <form action='../includes/admin_functions.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='user_id' value='<?php echo $user['id']; ?>'>
                            <button type='submit' name='promouvoir_admin'>Promouvoir admin</button>
                        </form>
                        <form action='../includes/admin_functions.php' method='POST' style='display:inline;'
                        onsubmit='return confirm("Voulez-vous vraiment supprimer cet utilisateur ?");'>
                            <input type='hidden' name='user_id' value='<?php echo $user['id']; ?>'>
                            <button type='submit' name='delete_user'>Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>