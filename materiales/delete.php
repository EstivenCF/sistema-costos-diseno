<?php
require_once __DIR__ . "/../config/db.php";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM materiales WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header("Location: index.php?page=materiales");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}