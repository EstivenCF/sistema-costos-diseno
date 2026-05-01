<?php
require __DIR__ . "/../config/db.php";

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$precio_venta = $_POST['precio_venta'];

$stmt = $conn->prepare("
    UPDATE trabajos 
    SET nombre = ?, precio_venta = ?
    WHERE id = ?
");

$stmt->execute([$nombre, $precio_venta, $id]);

$stmt = $conn->prepare("DELETE FROM trabajo_materiales WHERE trabajo_id = ?");
$stmt->execute([$id]);

$materiales = $_POST['material_id'];
$cantidades = $_POST['cantidad'];

for ($i = 0; $i < count($materiales); $i++) {

    $material_id = $materiales[$i];
    $cantidad = $cantidades[$i];

    $stmt = $conn->prepare("SELECT precio_por_unidad FROM materiales WHERE id = ?");
    $stmt->execute([$material_id]);
    $material = $stmt->fetch(PDO::FETCH_ASSOC);

    $precio_unitario = $material['precio_por_unidad'];

    $stmt = $conn->prepare("
        INSERT INTO trabajo_materiales 
        (trabajo_id, material_id, cantidad_usada, precio_unitario)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([$id, $material_id, $cantidad, $precio_unitario]);
}

header("Location: index.php?page=trabajos");
exit;