<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si el correo o teléfono ya están en uso
    $checkEmailQuery = "SELECT * FROM usuarios WHERE email = '$email'";
    $checkPhoneQuery = "SELECT * FROM usuarios WHERE telefono = '$telefono'";
    
    $emailResult = $conn->query($checkEmailQuery);
    $phoneResult = $conn->query($checkPhoneQuery);

    if ($emailResult->num_rows > 0) {
        // El correo electrónico ya está en uso. Redirigir a la página de registro con mensaje de error
        header("Location: ../registro/registro.php?email_error=true");
        exit();
    } elseif ($phoneResult->num_rows > 0) {
        // El número de teléfono ya está en uso. Redirigir a la página de registro con mensaje de error
        header("Location: ../registro/registro.php?telefono_error=true");
        exit();
    } else {
        // Si el correo y el teléfono no están en uso, procede con el registro.
        $sql = "INSERT INTO usuarios (nombre, telefono, email, password) VALUES ('$nombre', '$telefono', '$email', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            // Registro exitoso. Redirigir a la página de registro con mensaje de éxito
            header("Location: ../registro/registro.php?mensaje=¡Registro%20exitoso!%20Ahora%20puedes%20iniciar%20sesión%20con%20tu%20nueva%20cuenta.");
            exit();
        } else {
            // Error al registrar usuario. Mostrar mensaje de error.
            echo "Error al registrar usuario: " . $conn->error;
            // Redirigir a la página de registro
            header("refresh:5; url=../registro/registro.php");
            exit();
        }
    }
}

// Cerrar la conexión después de usarla
$conn->close();
?>
