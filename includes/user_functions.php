<?php
require_once 'db.php';

$host = 'localhost';
$db = 'mydatabase';  // Make sure to replace 'your_database' with the actual database name
$user = 'root';
$password = ''; // Replace with your actual password
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

?>