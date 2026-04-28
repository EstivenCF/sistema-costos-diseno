<?php
require_once "../config/db.php";

$stmt = $conn->query("SELECT * FROM materiales ORDER BY id DESC");
$materiales = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Materiales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>Materiales</h2>

    <a href="create.php" class="btn btn-success mb-3">Nuevo Material</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Unidad</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materiales as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['nombre']) ?></td>
                    <td><?= htmlspecialchars($m['unidad']) ?></td>
                    <td><?= $m['precio_por_unidad'] ?>
                </td>
                
                <td>
                    <a href="edit.php?id=<?= $m['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="delete.php?id=<?= $m['id'] ?>" 
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Seguro que quieres eliminar este material?')">
                        Eliminar
                    </a>
                </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
