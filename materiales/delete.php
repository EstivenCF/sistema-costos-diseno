<?php
require_once "../config/db.php";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM materiales WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header("Location: index.php");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}