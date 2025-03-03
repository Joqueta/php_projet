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
<link rel="stylesheet" type="text/css" href="../css/stylesheet_gerercommentaires.css">
    <title>Administration</title>
</head>
<body>
    <?php 
        include "../includes/navbar.php";
        echo createHeader();
        function getComments($pdo) {
        $stmt = $pdo->prepare("SELECT comments.*, users.username FROM comments INNER JOIN users ON comments.user_id = users.id");
        $stmt->execute();
        return $stmt->fetchAll();
        }
        $comments = getComments($pdo);
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
    <h2>Commentaires du site</h2>
    <table>
        <thead>
            <tr>
                <th>ID Commentaire</th>
                <th>Utilisateur</th>
                <th>Commentaire</th>
                <th>Date de Création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($comment['id']); ?></td>
                    <td><?php echo htmlspecialchars($comment['username']); ?></td>
                    <td><?php echo htmlspecialchars($comment['comment']); ?></td>
                    <td><?php echo htmlspecialchars($comment['created_at']); ?></td>
                    <td>
                        <form action="../includes/admin_functions.php" method="POST" style="display:inline;">
                            <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($comment['id']); ?>">
                            <button type="submit" name="delete_comment">Ajouter une tâche</button>
                        </form>
                    </td>
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>