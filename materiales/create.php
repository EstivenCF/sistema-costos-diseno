<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Material</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>Crear Material</h2>

    <form method="POST" action="index.php?page=guardar_material">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Unidad (ej: pie, yarda)</label>
            <select name="unidad" class="form-control mb-2">
                <option value="pie">Pie</option>
                <option value="yarda">Yarda</option>
                <option value="metro">Metro</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Precio por unidad</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>

</body>
</html>