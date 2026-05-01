<?php require __DIR__ . "/../config/db.php"; 
$stmt = $conn->query("SELECT * FROM materiales");
$materiales = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Trabajo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2>Nuevo Trabajo</h2>

<form method="POST" action="index.php?page=guardar_trabajo" onsubmit="return validarAntesDeGuardar()">

    <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre del trabajo" required>

    <input type="number" step="0.01" name="precio_venta" class="form-control mb-2" placeholder="Precio de venta" required>

    <div class="mb-3">
        <label>Costo total (automático)</label>
        <input type="text" id="costo_total" class="form-control" readonly>
    </div>

<div id="alerta" class="text-danger fw-bold mb-2"></div>

<div id="materiales-container">

    <div class="material-item mb-2 border p-2">
        
        <select name="material_id[]" class="form-control mb-1 material" required>
            <?php foreach ($materiales as $m): ?>
                <option value="<?= $m['id'] ?>">
                    <?= $m['nombre'] ?> (<?= $m['unidad'] ?>)
                </option>
            <?php endforeach; ?>
        </select>

    <input type="number" step="0.01" name="cantidad[]" 
        class="form-control mb-2 cantidad" placeholder="Cantidad" required>

        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarMaterial(this)">
            Eliminar
        </button>

    </div>

</div>

<button type="button" class="btn btn-secondary mb-3" onclick="agregarMaterial()">
    + Agregar otro material
</button>

    <button class="btn btn-primary">Guardar Trabajo</button>

</form>

<script>
function agregarMaterial() {
    let container = document.getElementById('materiales-container');
    let nuevo = container.children[0].cloneNode(true);

    // limpiar valores
    nuevo.querySelector('input').value = "";

    container.appendChild(nuevo);
}

function eliminarMaterial(boton) {
    let container = document.getElementById('materiales-container');

    // evitar que se borre el último
    if (container.children.length > 1) {
        boton.parentElement.remove();
    } else {
        alert("Debe haber al menos un material");
    }
}
</script>

<script>
const materiales = <?php echo json_encode($materiales); ?>;

function calcularCosto() {
    let total = 0;

    const items = document.querySelectorAll(".material-item");

    items.forEach(item => {
        const select = item.querySelector(".material");
        const input = item.querySelector(".cantidad");

        const materialId = select.value;
        const cantidad = parseFloat(input.value) || 0;

        const material = materiales.find(m => m.id == materialId);

        if (material) {
            total += cantidad * parseFloat(material.precio_por_unidad);
        }
    });

    document.getElementById("costo_total").value = total.toFixed(2);

    verificarGanancia(total);
}

function verificarGanancia(costo) {
    const precioVenta = parseFloat(document.querySelector("[name='precio_venta']").value) || 0;
    const alerta = document.getElementById("alerta");

    if (precioVenta < costo) {
        alerta.innerHTML = "⚠ Estás vendiendo por debajo del costo (pérdida)";
    } else {
        alerta.innerHTML = "";
    }
}

// 👇 detectar cambios en todo
document.addEventListener("input", calcularCosto);
document.addEventListener("change", calcularCosto);
</script>

<script>
function validarAntesDeGuardar() {
    const costo = parseFloat(document.getElementById("costo_total").value) || 0;
    const precio = parseFloat(document.querySelector("[name='precio_venta']").value) || 0;

    if (precio < costo) {
        return confirm("⚠ Estás vendiendo por debajo del costo.\n¿Seguro que quieres continuar?");
    }

    return true;
}
</script>
</body>
</html>