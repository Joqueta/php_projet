<?php

function createUsersTable(PDO $pdo) {
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE
    )";

    try {
        $pdo->exec($sql);
        echo "Table `users` créée avec succès.";
    } catch (PDOException $e) {
        echo 'Erreur de création de la table : ' . $e->getMessage();
    }
}

$pdo = getDBConnection();
createUsersTable($pdo);
?>