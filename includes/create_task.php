<?php
session_start();
require_once 'db.php'; // Fichier contenant la connexion PDO

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté pour ajouter une tâche.");
}

$pdo = getDBConnection(); // Connexion à la BDD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $category_id = isset($_POST["category_id"]) ? intval($_POST["category_id"]) : NULL;
    $user_id = $_SESSION['user_id']; // ID de l'utilisateur connecté

    if (empty($title)) {
        die("Le titre est obligatoire !");
    }

    try {
        $sql = "INSERT INTO tasks (user_id, category_id, title, description, status, created_at) 
                VALUES (:user_id, :category_id, :title, :description, 'pending', NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':category_id' => $category_id,
            ':title' => $title,
            ':description' => $description
        ]);

        echo "Tâche ajoutée avec succès !";
        header("Location: ./../views/dashboard.php"); // Redirection après ajout
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>