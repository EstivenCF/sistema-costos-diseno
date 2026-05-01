<?php
$page = $_GET['page'] ?? 'home';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100vh;
            background-color: #212529;
            color: white;
            z-index: 1000;
        }

        .sidebar a {
            color: white;
            display: block;
            padding: 12px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #343a40;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4 class="p-3">Sistema</h4>

    <a href="index.php?page=home">🏠 Inicio</a>
    <a href="index.php?page=trabajos">🛠 Trabajos</a>
    <a href="index.php?page=materiales">📦 Materiales</a>
</div>

<!-- CONTENIDO -->
<div class="content">

    <div class="card p-3">

        <?php
        if ($page == 'trabajos') {
            include 'trabajos/index.php';

        } elseif ($page == 'materiales') {
            include 'materiales/index.php';

        } elseif ($page == 'crear_material') {
            include 'materiales/create.php';

        } elseif ($page == 'guardar_material') {
            include 'materiales/store.php';

        } elseif ($page == 'editar_material') {
            include 'materiales/edit.php';

        } elseif ($page == 'actualizar_material') {
            include 'materiales/update.php';

        } elseif ($page == 'eliminar_material') {
            include 'materiales/delete.php';
        
        } elseif ($page == 'crear_trabajo') {
            include 'trabajos/crear_trabajo.php';

        } elseif ($page == 'guardar_trabajo') {
           include 'trabajos/guardar_trabajo.php';
        
        } elseif ($page == 'ver_trabajo') {
            include 'trabajos/ver_trabajo.php';

        } elseif ($page == 'editar_trabajo') {
            include 'trabajos/editar_trabajo.php';

        } elseif ($page == 'actualizar_trabajo') {
           include 'trabajos/actualizar_trabajo.php';
        
        } elseif ($page == 'eliminar_trabajo') {
            include 'trabajos/eliminar_trabajo.php';
            
        } elseif ($page == 'home') {
            require __DIR__ . "/config/db.php";

            // Total ventas
            $stmt = $conn->query("SELECT COALESCE(SUM(precio_venta),0) AS total FROM trabajos");
            $total_ventas = $stmt->fetch()['total'];

            // Total costos
            $stmt = $conn->query("
                SELECT COALESCE(SUM(cantidad_usada * precio_unitario),0) AS total 
                FROM trabajo_materiales
            ");
            $total_costos = $stmt->fetch()['total'];

            // Ganancia
            $ganancia = $total_ventas - $total_costos;
        ?>

            <h3 class="mb-4">Dashboard</h3>

            <div class="row">

                <div class="col-md-4">
                    <div class="card p-3 text-center">
                        <h5>Total Ventas</h5>
                        <h3 class="text-primary"><?= number_format($total_ventas,2) ?></h3>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-3 text-center">
                        <h5>Total Costos</h5>
                        <h3 class="text-danger"><?= number_format($total_costos,2) ?></h3>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card p-3 text-center">
                        <h5>Ganancia</h5>
                        <h3 class="<?= $ganancia < 0 ? 'text-danger' : 'text-success' ?>">
                            <?= number_format($ganancia,2) ?>
                        </h3>
                    </div>
                </div>

            </div>

        <?php
        }
        ?>

    </div>

</div>

</body>
</html>