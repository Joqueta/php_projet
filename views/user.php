<?php
require_once '../includes/db.php';
require_once '../includes/user_functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$pdo = getDBConnection();
$user_id = $_SESSION["user_id"];

// Récupérer les informations de l'utilisateur
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = :user_id");
$stmt->execute([":user_id" => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Mise à jour du nom d'utilisateur
    if (isset($_POST["update_username"])) {
        $new_username = trim($_POST["new_username"]);

        if (!empty($new_username)) {
            $stmt = $pdo->prepare("UPDATE users SET username = :username WHERE id = :user_id");
            $stmt->execute([":username" => $new_username, ":user_id" => $user_id]);
            $_SESSION["username"] = $new_username;
            $success = "Nom d'utilisateur mis à jour avec succès !";
        } else {
            $error = "Le champ du nom d'utilisateur ne peut pas être vide.";
        }
    }

    // Mise à jour de l'email
    if (isset($_POST["update_email"])) {
        $new_email = trim($_POST["new_email"]);

        if (!empty($new_email) && filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = :user_id");
            $stmt->execute([":email" => $new_email, ":user_id" => $user_id]);
            $success = "Adresse e-mail mise à jour avec succès !";
        } else {
            $error = "Veuillez entrer une adresse e-mail valide.";
        }
    }

    // Mise à jour du mot de passe
    if (isset($_POST["update_password"])) {
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];

        if (!empty($new_password) && $new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :user_id");
            $stmt->execute([":password" => $hashed_password, ":user_id" => $user_id]);
            $success = "Mot de passe mis à jour avec succès !";
        } else {
            $error = "Les mots de passe ne correspondent pas.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon profil</title>
    <link rel="stylesheet" href="../css/stylesheet_user.css">
</head>
<body>
    <?php 
        include "../includes/navbar.php";
        echo createHeader();
    ?>
    <h2>Modifier mon profil</h2>

    <?php if ($success) : ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <?php if ($error) : ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <h3>Changer de nom d'utilisateur</h3>
        <label for="new_username">Nouveau nom d'utilisateur :</label>
        <input type="text" id="new_username" name="new_username" value="<?= htmlspecialchars($user["username"]) ?>" required>
        <button type="submit" name="update_username">Mettre à jour</button>
    </form>

    <form method="POST">
        <h3>Changer d'adresse e-mail</h3>
        <label for="new_email">Nouvelle adresse e-mail :</label>
        <input type="email" id="new_email" name="new_email" value="<?= htmlspecialchars($user["email"]) ?>" required>
        <button type="submit" name="update_email">Mettre à jour</button>
    </form>

    <form method="POST">
        <h3>Changer de mot de passe</h3>
        <label for="new_password">Nouveau mot de passe :</label>
        <input type="password" id="new_password" name="new_password" required>
        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <button type="submit" name="update_password">Mettre à jour</button>
    </form>

    <a href="login.php">Retour vers la page de connexion</a>
</body>
</html>