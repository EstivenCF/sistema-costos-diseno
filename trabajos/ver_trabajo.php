<?php
require __DIR__ . "/../config/db.php";

$id = $_GET['id'];

// Obtener datos del trabajo
$stmt = $conn->prepare("SELECT * FROM trabajos WHERE id = ?");
$stmt->execute([$id]);
$trabajo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$trabajo) {
    die("Trabajo no encontrado");
}

// Obtener materiales del trabajo
$stmt = $conn->prepare("
    SELECT m.nombre, m.unidad,
           tm.cantidad_usada,
           tm.precio_unitario,
           tm.costo_calculado
    FROM trabajo_materiales tm
    JOIN materiales m ON tm.material_id = m.id
    WHERE tm.trabajo_id = ?
");
$stmt->execute([$id]);
$materiales = $stmt->fetchAll(PDO::FETCH_ASSOC);

// calcular total
$total = 0;
foreach ($materiales as $m) {
    $total += $m['costo_calculado'];
}

$ganancia = $trabajo['precio_venta'] - $total;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detalle del Trabajo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2><?= $trabajo['nombre'] ?></h2>

<p><strong>Precio de venta:</strong> <?= $trabajo['precio_venta'] ?></p>
<p><strong>Costo total:</strong> <?= $total ?></p>
<h4 class="<?= $ganancia < 0 ? 'text-danger' : 'text-success' ?>">
    Ganancia: <?= $ganancia ?>
</h4>

<hr>

<h4>Materiales usados</h4>

<table class="table table-bordered">
    <tr>
        <th>Material</th>
        <th>Unidad</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Costo</th>
    </tr>

    <?php foreach ($materiales as $m): ?>
    <tr>
        <td><?= $m['nombre'] ?></td>
        <td><?= $m['unidad'] ?></td>
        <td><?= $m['cantidad_usada'] ?></td>
        <td><?= $m['precio_unitario'] ?></td>
        <td><?= $m['costo_calculado'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="index.php?page=trabajos" class="btn btn-secondary">Volver</a>

</body>
</html>