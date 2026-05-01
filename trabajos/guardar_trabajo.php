<?php
require __DIR__ . "/../config/db.php";

$nombre = $_POST['nombre'];
$precio_venta = $_POST['precio_venta'];

$materiales = $_POST['material_id'];
$cantidades = $_POST['cantidad'];

// 1. Crear trabajo primero
$stmt = $conn->prepare("INSERT INTO trabajos (nombre, precio_venta) VALUES (?, ?) RETURNING id");
$stmt->execute([$nombre, $precio_venta]);
$trabajo_id = $stmt->fetchColumn();

// 2. Recorrer materiales
for ($i = 0; $i < count($materiales); $i++) {

    $material_id = $materiales[$i];
    $cantidad = $cantidades[$i];

    // Obtener precio del material
    $stmt = $conn->prepare("SELECT precio_por_unidad FROM materiales WHERE id = ?");
    $stmt->execute([$material_id]);
    $material = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$material) {
        die("Material no encontrado");
    }

    $precio_unitario = $material['precio_por_unidad'];

    // Guardar relación
    $stmt = $conn->prepare("
        INSERT INTO trabajo_materiales 
        (trabajo_id, material_id, cantidad_usada, precio_unitario)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([$trabajo_id, $material_id, $cantidad, $precio_unitario]);
}

// 3. Redirigir
header("Location: index.php?page=trabajos");
exit;