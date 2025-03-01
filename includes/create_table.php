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

function createCategoriesTable(PDO $pdo) {
    $sql = "CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    try {
        $pdo->exec($sql);
        echo "Table `categories` créée avec succès.<br>";
    } catch (PDOException $e) {
        echo 'Erreur de création de la table `categories` : ' . $e->getMessage() . "<br>";
    }
}

function createTasksTable(PDO $pdo) {
    $sql = "CREATE TABLE IF NOT EXISTS tasks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        category_id INT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT NULL,
        importance VARCHAR(50),
        due_date DATE NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
    )";

    try {
        $pdo->exec($sql);
        echo "Table `tasks` créée avec succès.<br>";
    } catch (PDOException $e) {
        echo 'Erreur de création de la table `tasks` : ' . $e->getMessage() . "<br>";
    }
}

function createCommentsTable(PDO $pdo) {
    $sql = "CREATE TABLE IF NOT EXISTS comments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        task_id INT NOT NULL,
        user_id INT NOT NULL,
        comment TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";

    try {
        $pdo->exec($sql);
        echo "Table `comments` créée avec succès.<br>";
    } catch (PDOException $e) {
        echo 'Erreur de création de la table `comments` : ' . $e->getMessage() . "<br>";
    }
}

function createAttachmentsTable(PDO $pdo) {
    $sql = "CREATE TABLE IF NOT EXISTS attachments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        task_id INT NOT NULL,
        filename VARCHAR(255) NOT NULL,
        file_path VARCHAR(255) NOT NULL,
        uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE
    )";

    try {
        $pdo->exec($sql);
        echo "Table `attachments` créée avec succès.<br>";
    } catch (PDOException $e) {
        echo 'Erreur de création de la table `attachments` : ' . $e->getMessage() . "<br>";
    }
}
?>