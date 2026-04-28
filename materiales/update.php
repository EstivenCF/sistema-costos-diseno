<?php
require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $unidad = $_POST["unidad"];
    $precio = $_POST["precio"];

    try {
        $sql = "UPDATE materiales 
                SET nombre = :nombre, unidad = :unidad, precio_por_unidad = :precio
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':unidad', $unidad);
        $stmt->bindParam(':precio', $precio);

        $stmt->execute();

        header("Location: index.php");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}