<?php
require __DIR__ . "/../config/db.php";

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM trabajos WHERE id = ?");
$stmt->execute([$id]);
$trabajo = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener lista de materiales
$stmt = $conn->query("SELECT * FROM materiales");
$lista_materiales = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener materiales del trabajo
$stmt = $conn->prepare("
    SELECT * FROM trabajo_materiales WHERE trabajo_id = ?
");
$stmt->execute([$id]);
$materiales_trabajo = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$trabajo) {
    die("Trabajo no encontrado");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Trabajo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2>Editar Trabajo</h2>

<form method="POST" action="index.php?page=actualizar_trabajo">

    <input type="hidden" name="id" value="<?= $trabajo['id'] ?>">

    <div class="mb-3">
        <label>Nombre del trabajo</label>
        <input type="text" name="nombre" class="form-control"
            value="<?= $trabajo['nombre'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Precio de venta (RD$)</label>
        <input type="number" step="0.01" name="precio_venta" class="form-control"
            value="<?= $trabajo['precio_venta'] ?>" required>
    </div>

    <h4>Materiales</h4>

    <div id="contenedor-materiales">

        <?php foreach ($materiales_trabajo as $m): ?>
            <div class="row mb-2">

                <div class="col">
                    <select name="material_id[]" class="form-control">
                        <?php foreach ($lista_materiales as $mat): ?>
                            <option value="<?= $mat['id'] ?>"
                                <?= $mat['id'] == $m['material_id'] ? 'selected' : '' ?>>
                                <?= $mat['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col">
                    <input type="number" step="0.01" name="cantidad[]" class="form-control"
                        value="<?= $m['cantidad_usada'] ?>">
                </div>

            </div>
        <?php endforeach; ?>

    </div>

    <button class="btn btn-primary">Actualizar</button>

</form>

</body>
</html>