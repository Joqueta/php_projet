<?php
require_once 'db.php';
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

function isAdmin(){
    return isset($_SESSION["role"]) && $_SESSION["role"] === 'admin';
}

function userToAdmin($user_id) {
    if (isset($user_id)) {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE id = :id");
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Utilisateur promu en administrateur !";
        } else {
            $_SESSION['error'] = "Erreur lors de la promotion.";
        }
    }    
} 

function deleteUser($user_id){
    if (isset($user_id)) {
        $pdo= getDBConnection();
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id"); 
        $stmt->execute(['id' => $user_id]);
    } 
}
// Vérification de la méthode de requête pour la promotion admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['promouvoir_admin']) && isset($_POST['user_id'])) { 
    userToAdmin($_POST['user_id']);
    header("Location: ../views/pages_admin/gerer_utilisateurs.php");
    exit();
}

// Vérification de la méthode de requête pour la suppression d'utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user']) && isset($_POST['user_id'])) {
    deleteUser($_POST['user_id']);
    header("Location: ../views/pages_admin/gerer_utilisateurs.php");
    exit();
}
?>