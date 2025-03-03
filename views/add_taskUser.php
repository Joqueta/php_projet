<?php
require_once '../includes/db.php';
require_once '../includes/admin_functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    header("Location: views/login.php");
    exit();
}

$pdo = getDBConnection();
$stmt = $pdo->prepare("SELECT id, username FROM users");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une Tâche</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesheet_addtaskuser.css">
</head>
<body>
    <h1>Ajouter une Tâche</h1>
    <form action="../includes/admin_functions.php" method="POST">
        <label for="user_id">Utilisateur :</label>
        <select name="user_id" required>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo htmlspecialchars($user['id']); ?>"><?php echo htmlspecialchars($user['username']); ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="description">Description :</label>
        <textarea name="description" required></textarea>
        <br>
        <label for="due_date">Date d'échéance :</label>
        <input type="date" name="due_date" required>
        <br>
        <button type="submit">Ajouter Tâche</button>
    </form>
</body>
</html>
