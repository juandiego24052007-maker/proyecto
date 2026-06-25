<?php 

$host = "localhost";
$user = "root";
$pass = "";
$db   = "catalogo_animales";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// --- LÓGICA DE AGREGAR ---
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $edad = $_POST['edad'];
    $peso = $_POST['peso'];
    $genero = $_POST['genero'];
    $color = $_POST['color'];
    $fecha = $_POST['fecha_ingreso'];
    $estado = $_POST['estado_salud'];

    $stmt = $conn->prepare("INSERT INTO animales (nombre, especie, raza, edad, peso, genero, color, fecha_ingreso, estado_salud) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssidssss", $nombre, $especie, $raza, $edad, $peso, $genero, $color, $fecha, $estado);
    
    if ($stmt->execute()) {
        header("Location: index.php?msg=agregado");
        exit();
    }
}

// --- LÓGICA DE ELIMINAR ---
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conn->prepare("DELETE FROM animales WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: index.php?msg=eliminado");
        exit();
    }
}

// --- LÓGICA DE MODIFICAR ---
if (isset($_POST['modificar'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $edad = $_POST['edad'];
    $peso = $_POST['peso'];
    $genero = $_POST['genero'];
    $color = $_POST['color'];
    $fecha = $_POST['fecha_ingreso'];
    $estado = $_POST['estado_salud'];

    $stmt = $conn->prepare("UPDATE animales SET nombre=?, especie=?, raza=?, edad=?, peso=?, genero=?, color=?, fecha_ingreso=?, estado_salud=? WHERE id=?");
    $stmt->bind_param("sssidssssi", $nombre, $especie, $raza, $edad, $peso, $genero, $color, $fecha, $estado, $id);
    
    if ($stmt->execute()) {
        header("Location: index.php?msg=modificado");
        exit();
    }
}

// --- CONFIGURACIÓN DE LA PAGINACIÓN (LÍMITE DE 3 COMO TU PANA) ---
$registros_por_pagina = 3; 
$pagina_actual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

// Obtener el total de registros para calcular las páginas
$total_resultado = $conn->query("SELECT COUNT(*) as total FROM animales");
$total_filas = $total_resultado->fetch_assoc()['total'];

$total_paginas = ceil($total_filas / $registros_por_pagina);
$desplazamiento = ($pagina_actual - 1) * $registros_por_pagina;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Animales - Paginación de 3 en 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Gestión y Control de Animales</h2>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <strong>¡Éxito!</strong> 
            <?php
                if ($_GET['msg'] == 'agregado') echo "Animal registrado correctamente.";
                if ($_GET['msg'] == 'eliminado') echo "Registro eliminado correctamente.";
                if ($_GET['msg'] == 'modificado') echo "Datos actualizados correctamente.";
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-secondary" id="formTitulo">Registrar Nuevo Animal</h5>
            <form action="index.php" method="POST" id="formAnimal">
                <input type="hidden" name="id" id="animal_id">
                
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Especie</label>
                        <input type="text" name="especie" id="especie" class="form-control" placeholder="Ej: Perro" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Raza</label>
                        <input type="text" name="raza" id="raza" class="form-control" placeholder="Raza">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">Edad</label>
                        <input type="number" name="edad" id="edad" class="form-control" min="0">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Peso (kg)</label>
                        <input type="number" step="0.01" name="peso" id="peso" class="form-control" min="0">
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">Género</label>
                        <select name="genero" id="genero" class="form-select">
                            <option value="Macho">Macho</option>
                            <option value="Hembra">Hembra</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Color</label>
                        <input type="text" name="color" id="color" class="form-control" placeholder="Color">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha Ingreso</label>
                        <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Estado Salud</label>
                        <input type="text" name="estado_salud" id="estado_salud" class="form-control" placeholder="Salud">
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" name="agregar" id="btnAccion" class="btn btn-primary w-100 py-2">Guardar</button>
                        <button type="button" id="btnCancelar" class="btn btn-secondary py-2 d-none" onclick="resetearFormulario()">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-3 g-2">
        <div class="col-md-8">
            <input type="text" id="buscador" class="form-control shadow-sm" placeholder="🔍 Escribe para buscar animales en la página actual...">
        </div>
        <div class="col-md-4 d-flex gap-2 justify-content-md-end">
            <button class="btn btn-outline-secondary shadow-sm" onclick="window.print()"><i class="bi bi-printer"></i> Imprimir</button>
            <button class="btn btn-outline-success shadow-sm" onclick="alert('Exportación a Excel simulada con éxito')"><i class="bi bi-file-earmark-excel"></i> Exportar</button>
        </div>
    </div>

    <div class="table-responsive bg-white p-3 rounded shadow-sm">
        <table class="table table-hover align-middle" id="tablaAnimales">
            <thead class="table-dark">
                <tr>
                    <th>ID</th><th>Nombre</th><th>Especie</th><th>Raza</th><th>Edad</th>
                    <th>Peso</th><th>Género</th><th>Color</th><th>Ingreso</th><th>Salud</th><th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta con LIMIT 3 para paginar exactamente como quieres
                $resultado = $conn->query("SELECT * FROM animales ORDER BY id DESC LIMIT $registros_por_pagina OFFSET $desplazamiento");
                if ($resultado->num_rows > 0):
                    while ($row = $resultado->fetch_assoc()):
                ?>
                <tr>
                    <td><strong><?php echo $row['id']; ?></strong></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['especie']); ?></td>
                    <td><?php echo htmlspecialchars($row['raza']); ?></td>
                    <td><?php echo $row['edad']; ?> años</td>
                    <td><?php echo $row['peso']; ?> kg</td>
                    <td><?php echo $row['genero']; ?></td>
                    <td><?php echo htmlspecialchars($row['color']); ?></td>
                    <td><?php echo $row['fecha_ingreso']; ?></td>
                    <td><?php echo htmlspecialchars($row['estado_salud']); ?></td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button class="btn btn-warning btn-sm" onclick='cargarDatos(<?php echo json_encode($row); ?>)'><i class="bi bi-pencil-square"></i> Editar</button>
                            <a href="index.php?eliminar=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return registrarConfirmacion()"><i class="bi bi-trash"></i> Eliminar</a>
                        </div>
                    </td>
                </tr>
                <?php 
                    endwhile; 
                else:
                ?>
                <tr>
                    <td colspan="11" class="text-center text-muted">No hay animales en esta página.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($total_paginas > 1): ?>
        <nav aria-label="Navegación de páginas" class="mt-4">
            <ul class="pagination justify-content-center shadow-sm">
                
                <li class="page-item <?php echo ($pagina_actual <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="index.php?pagina=<?php echo $pagina_actual - 1; ?>">
                        <span>&laquo; Ant</span>
                    </a>
                </li>

                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <li class="page-item <?php echo ($pagina_actual == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?php echo ($pagina_actual >= $total_paginas) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="index.php?pagina=<?php echo $pagina_actual + 1; ?>">
                        <span>Sig &raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<script>
// Buscador dinámico de la tabla
document.getElementById('buscador').addEventListener('input', function() {
    let filtro = this.value.toLowerCase().trim();
    let filas = document.querySelectorAll('#tablaAnimales tbody tr');

    filas.forEach(fila => {
        let textoFila = fila.textContent.toLowerCase();
        if (textoFila.indexOf(filtro) > -1) {
            fila.style.display = ''; 
        } else {
            fila.style.display = 'none'; 
        }
    });
});

function registrarConfirmacion() {
    return confirm("¿Estás seguro de que deseas borrar este registro?");
}

// Al presionar editar, cambia el formulario y muestra botón Cancelar
function cargarDatos(animal) {
    document.getElementById('animal_id').value = animal.id;
    document.getElementById('nombre').value = animal.nombre;
    document.getElementById('especie').value = animal.especie;
    document.getElementById('raza').value = animal.raza;
    document.getElementById('edad').value = animal.edad;
    document.getElementById('peso').value = animal.peso;
    document.getElementById('genero').value = animal.genero;
    document.getElementById('color').value = animal.color;
    document.getElementById('fecha_ingreso').value = animal.fecha_ingreso;
    document.getElementById('estado_salud').value = animal.estado_salud;
    
    document.getElementById('formTitulo').textContent = "Modificar Datos del Animal (ID: " + animal.id + ")";
    
    let btn = document.getElementById('btnAccion');
    btn.name = "modificar";
    btn.textContent = "Actualizar";
    btn.className = "btn btn-success w-100";

    document.getElementById('btnCancelar').classList.remove('d-none');
}

// Limpia el formulario y oculta el botón Cancelar
function resetearFormulario() {
    document.getElementById('formAnimal').reset();
    document.getElementById('animal_id').value = "";
    document.getElementById('formTitulo').textContent = "Registrar Nuevo Animal";
    
    let btn = document.getElementById('btnAccion');
    btn.name = "agregar";
    btn.textContent = "Guardar";
    btn.className = "btn btn-primary w-100";

    document.getElementById('btnCancelar').classList.add('d-none');
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>