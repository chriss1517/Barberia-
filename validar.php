<?php
include '../conexion/conexion.php'; // Incluir el archivo de conexión

// Valores del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Consulta SQL preparada para evitar inyección SQL
$sqlUsuarios = "SELECT * FROM usuarios WHERE email = ? AND password = ?";
$stmtUsuarios = $conn->prepare($sqlUsuarios);
$stmtUsuarios->bind_param("ss", $email, $password);
$stmtUsuarios->execute();
$resultUsuarios = $stmtUsuarios->get_result();

// Verificar si el usuario existe en la tabla 'usuarios'
if ($resultUsuarios->num_rows > 0) {
    // Usuario encontrado en la tabla 'usuarios'
    session_start(); // Inicia la sesión si no está iniciada
    $_SESSION['id_usuario'] = $resultUsuarios->fetch_assoc()['id_usuario']; // Guarda el ID del usuario en la sesión
    header("Location: ../interfaz/interfaz_usua.php");
    exit();
} else {
    // Consulta SQL preparada para evitar inyección SQL en la tabla 'administrador'
    $sqlAdmin = "SELECT * FROM administrador WHERE email = ? AND password = ?";
    $stmtAdmin = $conn->prepare($sqlAdmin);
    $stmtAdmin->bind_param("ss", $email, $password);
    $stmtAdmin->execute();
    $resultAdmin = $stmtAdmin->get_result();

    // Verificar si el usuario existe en la tabla 'administrador'
    if ($resultAdmin->num_rows > 0) {
        // Usuario encontrado en la tabla 'administrador'
        session_start(); // Inicia la sesión si no está iniciada
        $_SESSION['id_administrador'] = $resultAdmin->fetch_assoc()['id_administrador']; // Guarda el ID del administrador en la sesión
        header("Location: ../interfazadmin/interfaz_admin.php");
        exit();
    } else {
        // Usuario no encontrado en ninguna tabla
        $_SESSION['error_message'] = "Email o contraseña incorrectos. Por favor, verifica tus credenciales.";
        header("Location: ../login/login.php");
        exit();
    }
}
?>
