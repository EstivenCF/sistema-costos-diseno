<?php
require_once __DIR__ . "/../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $unidad = $_POST["unidad"];
    $precio = $_POST["precio"];

    try {
        $sql = "INSERT INTO materiales (nombre, unidad, precio_por_unidad) 
                VALUES (:nombre, :unidad, :precio)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':unidad', $unidad);
        $stmt->bindParam(':precio', $precio);

        $stmt->execute();

        header("Location: index.php?page=materiales");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}