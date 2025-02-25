<?php
include_once '../includes/user_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = validateUser($username, $password);

    if ($user) {
        echo "Connexion réussie !";
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
    <title>Connexion</title>
</head>
<body>
    <h2>Formulaire de connexion</h2>
    <form action="login.php" method="post">
        <label for="username">Nom d'utilisateur:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Mot de passe:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Connexion">
    </form>
</body>
</html>