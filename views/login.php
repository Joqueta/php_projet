<?php
include_once '../includes/user_functions.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = validateUser($username, $password);

    if ($user) {
        // Stocker l'ID utilisateur dans la session
        $_SESSION["user_id"] = $user['id'];
        echo "Connexion réussie !";
        header("Location: dashboard.php");
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
echo "Session user_id : " . ($_SESSION["user_id"] ?? "Non défini");
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/stylesheet_login.css">
    <title>Connexion</title>
</head>
<body>
    <h2>Formulaire de connexion</h2>
    <form action="login.php" method="post">
        <label for="username">Nom d'utilisateur:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Mot de passe:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Connexion"><br>
        <a href="register.php">Vous n'avez pas de compte?</a>
    </form>
</body>
</html>