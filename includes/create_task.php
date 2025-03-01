<?php
require_once 'db.php'; // Fichier contenant la connexion PDO

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté pour ajouter une tâche.");
}


$pdo = getDBConnection(); // Connexion à la BDD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $category_id = isset($_POST["category_id"]) ? intval($_POST["category_id"]) : NULL;
    $importance = $_POST["importance"];
    $user_id = $_SESSION['user_id']; // ID de l'utilisateur connecté

    if (empty($title)) {
        die("Le titre est obligatoire !");
    }

    try {
        $sql = "INSERT INTO tasks (user_id, category_id, title, description, importance, created_at) 
                VALUES (:user_id, :category_id, :title, :description, :importance, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
        ":title" => $title,
        ":description" => $description,
        ":category_id" => $category_id,
        ":importance" => $importance,
        ":user_id" => $user_id
        ]);

        echo "Tâche ajoutée avec succès !";
        header("Location: ../views/dashboard.php"); // Redirection après ajout
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>