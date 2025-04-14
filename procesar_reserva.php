<?php
// Verificar si se han enviado datos desde el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    include '../conexion/conexion.php';

    // Obtener el id_usuario de la sesión si está definido
    session_start();
    if(isset($_SESSION['id_usuario'])) {
        $id_usuario = $_SESSION['id_usuario'];
    } else {
        $errores[] = "Error: No se pudo obtener el id_usuario.";
    }

    // Obtener los datos del formulario
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $tip_servico = $_POST['tip_servico']; // Asegúrate de que el nombre del campo en el formulario sea 'tip_servico'

    // Validar que los campos no estén vacíos
    if (!empty($fecha) && !empty($hora) && !empty($tip_servico)) {
        // Verificar si la hora ya está reservada
        $verificarReserva = "SELECT * FROM turnos WHERE fecha = ? AND hora = ?";
        $stmt_verificar = $conn->prepare($verificarReserva);
        $stmt_verificar->bind_param("ss", $fecha, $hora);
        $stmt_verificar->execute();
        $result_verificar = $stmt_verificar->get_result();

        if ($result_verificar->num_rows > 0) {
            // La hora ya está ocupada
            $_SESSION['hora_ocupada'] = "Hora ocupada. Por favor, seleccione otra hora.";
            // Redirigir al usuario a la página de interfaz_usua1.php
            header('Location: interfaz_usua1.php');
            exit;
        } else {
            // Query SQL para insertar el turno en la base de datos
            $insertarReserva = "INSERT INTO turnos (id_usuario, tiposervicio, fecha, hora) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertarReserva);
            $stmt->bind_param("isss", $id_usuario, $tip_servico, $fecha, $hora);

            // Ejecutar la consulta de inserción
            if ($stmt->execute()) {
                // Establecer un mensaje de reserva realizada en una variable de sesión
                $_SESSION['mensaje'] = "Reserva realizada";

                // Redirigir al usuario a la página de interfaz_usua1.php
                header('Location: interfaz_usua1.php');
                exit;
            } else {
                $errores[] = "Error al guardar la reserva: " . $conn->error;
            }
        }
    } else {
        $errores[] = "Todos los campos son obligatorios.";
    }
}
?>
