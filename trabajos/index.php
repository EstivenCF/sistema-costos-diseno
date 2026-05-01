<?php
require __DIR__ . "/../config/db.php";

$stmt = $conn->query("
    SELECT t.*, 
           COALESCE(SUM(tm.costo_calculado), 0) AS costo_total,
           (t.precio_venta - COALESCE(SUM(tm.costo_calculado), 0)) AS ganancia
    FROM trabajos t
    LEFT JOIN trabajo_materiales tm ON t.id = tm.trabajo_id
    GROUP BY t.id
    ORDER BY t.id DESC
");
$trabajos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trabajos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2 class="mb-4">Panel de Trabajos</h2>

<a href="index.php?page=crear_trabajo" class="btn btn-success mb-3">
    + Nuevo Trabajo
</a>

<table class="table table-bordered">
    <tr>
        <th>Nombre</th>
        <th>Precio Venta</th>
        <th>Fecha</th>
        <th>Costo</th>
        <th>Ganancia</th>
        <th>Acciones</th>        
    </tr>

    <?php foreach ($trabajos as $t): ?>
    <tr>
        <td><?= $t['nombre'] ?></td>
        <td><?= $t['precio_venta'] ?></td>
        <td><?= $t['fecha'] ?></td>
        <td><?= $t['costo_total'] ?></td>
        <td><?= $t['ganancia'] ?></td>   
        <td>
            <a href="index.php?page=ver_trabajo&id=<?= $t['id'] ?>" class="btn btn-info btn-sm">
                Ver
            </a>

            <a href="index.php?page=editar_trabajo&id=<?= $t['id'] ?>" class="btn btn-warning btn-sm">
                Editar
            </a>

            <a href="index.php?page=eliminar_trabajo&id=<?= $t['id'] ?>" 
            class="btn btn-danger btn-sm"
            onclick="return confirm('¿Seguro que quieres eliminar este trabajo?')">
                Eliminar
            </a>
        </td>  
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>