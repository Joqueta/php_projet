<?php
require_once 'db.php';

function validateUser($username, $password) {
    $pdo = getDBConnection();
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    } else {
        return false;
    }
}

function createUser(PDO $pdo, string $username, string $password, string $email): bool
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':email', $email);

    return $stmt->execute();
}

function login(PDO $pdo, array $credentials): array|false
{
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $statement->bindParam('email', $credentials['email']);
    $statement->execute();
    $user = $statement->fetch();
    return $user;
}

setlocale(LC_TIME, 'fr_FR.UTF-8', 'fr_FR', 'fr', 'French_France'); 
$date = new DateTime();

// Correction de l'encodage
$formattedDate = strftime('%A %d %B %Y', $date->getTimestamp());
$formattedDate = mb_convert_encoding($formattedDate, 'UTF-8', 'ISO-8859-1'); // Correction d'encodage

$formattedTime = $date->format('H:i');
?>