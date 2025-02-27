<?php
#session_start();
#if (!isset($_SESSION['user_id'])) {   #code mort
#    header("Location: login.php");
#    exit();
#}
require_once '../includes/db.php';
$pdo = getDBConnection();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une tâche</title>
</head>
<body>
    <h2>Ajouter une nouvelle tâche</h2>
    <form action="create_task.php" method="POST">
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description"></textarea>

        <label for="category_id">Catégorie :</label>
        <select id="category_id" name="category_id">
            <option value="">Aucune</option>
            <?php
            // Charger les catégories depuis la BDD
            $stmt = $pdo->query("SELECT id, name FROM categories");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
            }
            ?>
        </select>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>