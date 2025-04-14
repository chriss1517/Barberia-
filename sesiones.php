<?php
// Incluye el archivo de conexión a la base de datos
include '../conexion/conexion.php';

session_start(); // Inicia la sesión si no está iniciada

// Verifica si el usuario está logueado, si no, redirige a la página de inicio de sesión
if (!isset($_SESSION['id_administrador'])) {
    header("Location: ../inicio/index.php");
    exit();
}

// Obtener detalles del usuario conectado de la base de datos
if (isset($_SESSION['id_administrador'])) {
    $id_administrador = $_SESSION['id_administrador'];
    
    // Consulta SQL para obtener el nombre del usuario conectado
    $sql = "SELECT nombre FROM administrador WHERE id_administrador = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_administrador);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_usuario = $row['nombre'];
    } else {
        $nombre_usuario = "Administrador";
    }
} else {
    $nombre_usuario = "Administrador";
}

// Asigna el nombre del usuario a una variable de sesión para mostrarlo en la interfaz
$_SESSION['nombre_usuario'] = $nombre_usuario;

// Destruye la sesión actual al cerrar sesión
if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header("Location: ../inicio/index.php");
    exit();
}
?>
