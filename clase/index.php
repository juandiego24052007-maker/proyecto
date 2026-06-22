<?php 

$host = "localhost";
$user = "root";
$pass = "";
$db   = "catalogo_animales";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


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

    $sql = "INSERT INTO animales (nombre, especie, raza, edad, peso, genero, color, fecha_ingreso, estado_salud) 
            VALUES ('$nombre', '$especie', '$raza', '$edad', '$peso', '$genero', '$color', '$fecha', '$estado')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?msg=agregado");
        exit();
    }
}


if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM animales WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?msg=eliminado");
        exit();
    }
}


if (isset($_POST['modificar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $edad = $_POST['edad'];
    $peso = $_POST['peso'];
    $genero = $_POST['genero'];
    $color = $_POST['color'];
    $fecha = $_POST['fecha_ingreso'];
    $estado = $_POST['estado_salud'];

    $sql = "UPDATE animales SET nombre='$nombre', especie='$especie', raza='$raza', edad='$edad', 
            peso='$peso', genero='$genero', color='$color', fecha_ingreso='$fecha', estado_salud='$estado' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?msg=modificado");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Animales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4"> Gestión y Control de Animales</h2>

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
                    <div class="col-md-2 d-grid align-items-end">
                        <button type="submit" name="agregar" id="btnAccion" class="btn btn-primary py-2">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="mb-3">
        <input type="text" id="buscador" class="form-control shadow-sm" placeholder="🔍 Escribe para buscar animales en tiempo real (por nombre, especie, raza, etc)...">
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
                $resultado = $conn->query("SELECT * FROM animales ORDER BY id DESC");
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
                            <button class="btn btn-warning btn-sm" onclick='cargarDatos(<?php echo json_encode($row); ?>)'>Editar</button>
                            <a href="index.php?eliminar=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return registrarConfirmacion()">Eliminar</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>

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
    return confirm("¿Estás completamente seguro de que deseas eliminar este animal del registro?");
}


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
    btn.className = "btn btn-success py-2";
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>