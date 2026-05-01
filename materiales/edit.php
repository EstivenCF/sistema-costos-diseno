<?php
require_once __DIR__ . "/../config/db.php";

$id = $_GET['id'];

// Buscar material
$stmt = $conn->prepare("SELECT * FROM materiales WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

$material = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$material) {
    die("Material no encontrado");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Material</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Editar Material</h2>

<form action="index.php?page=actualizar_material" method="POST">

    <input type="hidden" name="id" value="<?= $material['id'] ?>">

    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control"
               value="<?= htmlspecialchars($material['nombre']) ?>" required>
    </div>

    <div class="mb-3">
        <label>Unidad</label>
        <select name="unidad" class="form-control" required>
            <option value="pie" <?= $material['unidad'] == 'pie' ? 'selected' : '' ?>>Pie</option>
            <option value="yarda" <?= $material['unidad'] == 'yarda' ? 'selected' : '' ?>>Yarda</option>
            <option value="metro" <?= $material['unidad'] == 'metro' ? 'selected' : '' ?>>Metro</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Precio</label>
        <input type="number" step="0.01" name="precio" class="form-control"
               value="<?= $material['precio_por_unidad'] ?>" required>
    </div>

    <button class="btn btn-primary">Actualizar</button>

</form>

</body>
</html>