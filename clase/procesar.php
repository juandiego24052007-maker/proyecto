<?php
// 1. CONEXIÓN DIRECTA INTEGRADA EN EL PROCESADOR
$host = "localhost";
$user = "root";
$pass = "";
$db   = "catalogo_animales";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión en el procesador: " . $conn->connect_error);
}

// 2. ACCIÓN: AGREGAR ANIMAL
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
    } else {
        echo "Error al registrar: " . $conn->error;
    }
}

// 3. ACCIÓN: ELIMINAR ANIMAL
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM animales WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?msg=eliminado");
        exit();
    } else {
        echo "Error al eliminar: " . $conn->error;
    }
}

// 4. ACCIÓN: MODIFICAR ANIMAL
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
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
}
?>