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

function isAdmin() {
    return isset($_SESSION["user_id"]) && isset($_SESSION["role"]) && $_SESSION["role"] === 'admin';
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
function createTask($user_id, $description, $due_date) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, description, due_date) VALUES (:user_id, :description, :due_date)");
    $stmt->execute([
        ":user_id" => $user_id,
        ":description" => $description,
        ":due_date" => $due_date
    ]);
}

// Vérificatio ncréation de tâche
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'], $_POST['description'], $_POST['due_date'])) {
    createTask($_POST['user_id'], $_POST['description'], $_POST['due_date']);
    header("Location: ../views/voir_taches.php");
    exit();
}

// Vérification promotion admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['promouvoir_admin']) && isset($_POST['user_id'])) { 
    userToAdmin($_POST['user_id']);
    header("Location: ../views/gerer_utilisateurs.php");
    exit();
}

// Vérification suppression d'utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user']) && isset($_POST['user_id'])) {
    deleteUser($_POST['user_id']);
    header("Location: ../views/gerer_utilisateurs.php");
    exit();
}
?>