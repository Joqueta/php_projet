<?php
function createDatabase(PDO $pdo) {
    $sql = "CREATE DATABASE IF NOT EXISTS mydatabase";
    try {
        $pdo->exec($sql);
        echo "Base de données `mydatabase` créée avec succès.<br>";
    } catch (PDOException $e) {
        echo 'Erreur de création de la base de données : ' . $e->getMessage();
    }
}

function getDBConnection($dbname = null) {
    $dsn = 'mysql:host=localhost';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($dbname) {
            $pdo->exec("USE $dbname");
        }
        return $pdo;
    } catch (PDOException $e) {
        echo 'Erreur de connexion : ' . $e->getMessage();
        exit;
    }
}

$pdo = getDBConnection();
createDatabase($pdo);

?>