<?php
require_once 'db.php';
require_once 'admin_functions.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$db = 'mydatabase'; 
$user = 'root';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

function validateUser($username, $password) { 
    $pdo = getDBConnection();
    $sql = "SELECT id, username, password, role FROM users WHERE username = :username"; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) { // Stocker les informations utilisateur dans la session
        $_SESSION["user_id"] = $user["id"]; 
        $_SESSION["username"] = $user["username"]; 
        $_SESSION["role"] = $user ["role"]; 
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