<?php
require_once '../includes/db.php';
require_once '../includes/user_functions.php';
require_once '../includes/create_table.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $pdo = getDBConnection();
    createUsersTable($pdo);
    createCategoriesTable($pdo);
    createTasksTable($pdo);
    createCommentsTable($pdo);
    createAttachmentsTable($pdo);
    $result = createUser($pdo, $username, $password, $email);

    if ($result) {
        echo "Utilisateur créé avec succès !";
    } else {
        echo "Erreur lors de la création de l'utilisateur.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
    <h2>Formulaire d'inscription</h2>
    <form action="register.php" method="post">
        <label for="username">Nom d'utilisateur:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Mot de passe:</label><br>
        <input type="password" id="password" name="password" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="Inscription">
    </form>