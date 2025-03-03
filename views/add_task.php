<?php

require_once '../includes/db.php';
require_once '../includes/user_functions.php';
require_once '../includes/create_task.php';
$pdo = getDBConnection();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/stylesheet_addtask.css">
    <title>Ajouter une tâche</title>
</head>
<body>
    <?php 
        include "../includes/navbar.php";
        echo createHeader();
    ?>
    <h2>Ajouter une nouvelle tâche</h2>
    <form action="../includes/create_task.php" method="POST" enctype="multipart/form-data">
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description"></textarea>

        <label for="importance">Importance :</label>
        <select id="importance" name="importance">
            <option value="Basse">Basse</option>
            <option value="Moyenne">Moyenne</option>
            <option value="Haute">Haute</option>
        </select>

        <label for="category_id">Catégorie :</label>
        <select id="category_id" name="category_id">
            <option value="">Aucune</option>
            <?php
            $stmt = $pdo->query("SELECT id, name FROM categories");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
            }
            ?>
        </select>

        <label for="attachment">Ajouter un fichier :</label>
        <input type="file" id="attachment" name="attachment">

        <input type="submit" value="Ajouter">
    </form>
</body>
</html>