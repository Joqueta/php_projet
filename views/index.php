<?php
require_once"../includes/user_functions.php";

$pdo = new PDO('mysql:host=localhost;dbname=mydatabase', 'root', '');

// Récupérer le nombre d'utilisateurs
$sql = "SELECT COUNT(*) AS user_count FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$userCount = $stmt->fetch(PDO::FETCH_ASSOC)['user_count'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur ToDo List</title>
    <link rel="stylesheet" href="../css/stylesheet_landingpage.css">
</head>
<body>
    <?php 
        include "../includes/navbar.php";
        echo createHeader();
    ?>

    <!-- Section d'introduction -->
    <section class="hero">
        <h1>Organise ta vie avec notre To-Do List intelligente</h1>
        <section class="date-time">
            <p id="current-date"><?php echo $formattedDate; ?></p>
            <p id="current-time"><?php echo $formattedTime; ?></p>
        </section>
        <p>Gère tes tâches quotidiennes simplement et efficacement, où que tu sois.</p>
        <a href="register.php" class="cta">Crée ton compte</a>
        <a href="login.php" class="cta">Connexion</a>
    </section>

    <!-- Section des statistiques -->
    <section class="stats">
        <h2>Quelques chiffres</h2>
        <p><strong><?php echo $userCount; ?></strong> personnes utilisent cette application pour organiser leur vie.</p>
    </section>

    <!-- Section des fonctionnalités -->
    <section class="features">
        <h2>Fonctionnalités principales</h2>
        <ul>
            <li>Créer des tâches rapidement</li>
            <li>Prioriser et organiser tes tâches</li>
        </ul>
    </section>

    <!-- Section des témoignages -->
    <section class="testimonials">
        <h2>Ce que disent nos utilisateurs</h2>
        <blockquote>"Cette application m'a permis de mieux gérer mon emploi du temps. Je ne peux plus m'en passer !" — Claire</blockquote>
    </section>

    <!-- Section FAQ -->
    <section class="faq">
        <h2>Questions fréquentes</h2>
        <p><strong>Q :</strong> Est-ce que l'application est gratuite ?<br><strong>R :</strong> Oui, l'application est entièrement gratuite.</p>
    </section>
    <!-- Footer -->
    <footer>
        <ul>
            <li><a href="privacy.php">Politique de confidentialité</a></li>
            <li><a href="terms.php">Conditions d'utilisation</a></li>
        </ul>
    </footer>

</body>
</html>