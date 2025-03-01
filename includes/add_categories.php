<?php
require_once '../includes/db.php';

$pdo = getDBConnection();

$categories = [
    'PHP',
    'JavaScript',
    'HTML',
    'CSS',
    'SQL',
    'Python',
    'C#',
];

foreach ($categories as $category) {
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
    $stmt->execute([':name' => $category]);
}

echo "Catégories ajoutées avec succès.";
?>