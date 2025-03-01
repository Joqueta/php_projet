<?php
require_once 'db.php'; // Fichier contenant la connexion PDO

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté pour ajouter une tâche.");
}

$pdo = getDBConnection(); // Connexion à la BDD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $category_id = isset($_POST["category_id"]) ? intval($_POST["category_id"]) : NULL;
    $importance = $_POST["importance"];
    $user_id = $_SESSION['user_id']; // ID de l'utilisateur connecté

    if (empty($title)) {
        die("Le titre est obligatoire !");
    }

    try {
        $pdo->beginTransaction();

        $sql = "INSERT INTO tasks (user_id, category_id, title, description, importance, created_at) 
                VALUES (:user_id, :category_id, :title, :description, :importance, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":title" => $title,
            ":description" => $description,
            ":category_id" => $category_id,
            ":importance" => $importance,
            ":user_id" => $user_id
        ]);

        $task_id = $pdo->lastInsertId();

        // Gérer le téléchargement du fichier
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['attachment']['tmp_name'];
            $fileName = $_FILES['attachment']['name'];
            $fileSize = $_FILES['attachment']['size'];
            $fileType = $_FILES['attachment']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = '../uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $sql = "INSERT INTO attachments (task_id, file_name, file_path, file_type, file_size, uploaded_at) 
                        VALUES (:task_id, :file_name, :file_path, :file_type, :file_size, NOW())";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ":task_id" => $task_id,
                    ":file_name" => $fileName,
                    ":file_path" => $dest_path,
                    ":file_type" => $fileType,
                    ":file_size" => $fileSize
                ]);
            } else {
                throw new Exception("Erreur lors du téléchargement du fichier.");
            }
        }

        $pdo->commit();

        echo "Tâche ajoutée avec succès !";
        header("Location: ../views/dashboard.php"); // Redirection après ajout
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}
?>