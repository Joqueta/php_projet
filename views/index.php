<?php
require_once"../includes/user_functions.php";

$pdo = new PDO('mysql:host=localhost;dbname=mydatabase', 'root', '');

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
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body>
    <script>AOS.init();</script>
    <?php 
        include "../includes/navbar.php";
        echo createHeader()
    ?>

    <section class="hero">
        <h1>Organise ta vie avec notre To-Do List intelligente</h1>
        <section class="date-time">
            <p id="current-date"><?php 
            $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
            $date = new DateTime();
            $formattedDate = $formatter->format($date);
            $formattedDate = ucfirst(mb_strtolower($formattedDate, 'UTF-8'));
            echo $formattedDate; ?></p>
            <div id="heure"><?php echo $formattedTime?></div>
        </section>
        <p>Gère tes tâches quotidiennes simplement et efficacement, où que tu sois.</p>
        <a href="register.php" class="cta">Crée ton compte</a>
        <a href="login.php" class="cta">Connexion</a>
    </section>

    <section class="stats">
        <h2 data-aos="fade-up">Quelques chiffres</h2>
        <p><strong><?php echo $userCount; ?></strong> personnes utilisent cette application pour organiser leur vie.</p>
    </section>

    <section class="features">
        <h2>Fonctionnalités principales</h2>
        <ul class="feature-list">
            <li><strong>Créer</strong> des tâches rapidement</li>
            <hr>
            <li><strong>Prioriser</strong> et <strong>organiser</strong> tes tâches</li>
        </ul>
    </section>

    <section class="testimonials">
        <h2 data-aos="fade-up">Ce que disent nos utilisateurs</h2>
        <?php
        $stmt = $pdo->query("SELECT comments.comment, users.username FROM comments JOIN users ON comments.user_id = users.id ORDER BY comments.created_at DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<blockquote>\"" . htmlspecialchars($row['comment']) . "\" — " . htmlspecialchars($row['username']) . "</blockquote>";
        }
        ?>
        <h3>Ajouter un commentaire</h3>
        <form action="../includes/submit_comment.php" method="POST">
            <textarea name="comment" required></textarea>
            <button type="submit">Soumettre</button>
        </form>
    </section>

    <section class="faq">
        <h2 data-aos="fade-up">Questions fréquentes</h2>
        <p><strong>Q :</strong> Est-ce que l'application est gratuite ?<br><strong>R :</strong> Oui, l'application est entièrement gratuite.</p>
    </section>
    <footer>
        <ul>
            <li><a href="privacy.php">Politique de confidentialité</a></li>
            <li><a href="terms.php">Conditions d'utilisation</a></li>
        </ul>
    </footer>

</body>
</html>