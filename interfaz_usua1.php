<?php
include 'sesiones.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="../img/logo.png" >
    <title>Barber shop 593</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../styles/styles.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="scriptc.js"></script>
    <link rel="stylesheet" href="estilodispo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="interfaz_usua.php">Barber Shop 593</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <ul class="navbar-nav ms-auto me-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user"></i> <?php echo $nombre_usuario; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="configuracion.php"><i class="fas fa-cog"></i> Configuración</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form class="dropdown-item" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <button type="submit" name="cerrar_sesion" class="btn btn-link"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Centro</div>
                    <a class="nav-link" href="../interfaz/interfaz_usua.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Panel
                    </a>
                    <div class="sb-sidenav-menu-heading">Interfaz</div>
                    <a class="nav-link" href="../interfaz/interfaz_usua1.php">
                        <div class="sb-nav-link-icon"><i class="far fa-calendar"></i></div>
                        <span>Agendar</span>
                    </a>                            
                    
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">

<!-- Cuerpo de la pagina -->

<div class="container">
    <div class="formu">
        <h1>Reservar</h1>
        <?php 
// Verificar si hay un mensaje de reserva realizada
if (isset($_SESSION['mensaje'])) {
    echo '<span id="mensaje" style="color: green; relative; top: 10px; right: 10px; font-size: 20px;">' . $_SESSION['mensaje'] . '</span>';
    unset($_SESSION['mensaje']); // Limpiar el mensaje de sesión
}

// Verificar si hay un mensaje de hora ocupada
if (isset($_SESSION['hora_ocupada'])) {
    echo '<span id="mensaje" style="color: red; position: relative; top: 10px; right: 10px; font-size: 20px;">' . $_SESSION['hora_ocupada'] . '</span>';
    unset($_SESSION['hora_ocupada']); // Limpiar el mensaje de sesión
}
?>

        <div id="calendar"></div>
  
        <form id="formularioReserva" action="procesar_reserva.php" method="post" onsubmit="return validarFormulario()">
        <label for="fecha"><b>Fecha:</b></label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="hora"><b>Hora:</b></label>
            <select id="hora" name="hora" required>
            <option value="">Selecciona una hora</option>
    <?php
    // Definir las horas disponibles
    $horas_disponibles = array(
        "08:00", "08:45", "09:30", "10:15",
        "11:00", "11:45", "12:30", "14:00",
        "14:45", "15:30", "16:15", "17:00",
        "17:45", "18:30", "19:15", "20:00",
        "20:45", "21:30"
    );

    // Mostrar las opciones
    foreach ($horas_disponibles as $hora) {
        echo "<option value=\"$hora\">$hora</option>";
    }
    ?>
</select>

            <label for="tip_servico"><b>Tipo de Servicio:</b></label>
            <select id="tip_servico" name="tip_servico">
                <option value="Corte de Cabello">Corte de Cabello</option>
                <option value="Corte de cabello + Barba">Corte de cabello + Barba</option>
                <option value="Titurado">Titurado</option>
                <option value="Afeitada">Afeitada</option>
                <option value="Proceso de Risos">Proceso de Risos</option>
                <option value="keratina">keratina</option>
                <option value="Corte de Puntas">Corte de Puntas</option>
                <option value="Depilación">Depilación</option>
            </select><br>

            <button type="submit">Reservar</button><br>
            <br><button type="button" onclick="redirigirAPagina()">Cancelar</button><br>
            <script>
                function redirigirAPagina() {
                    // Puedes cambiar 'URL_DESTINO' a la URL a la que deseas redirigir
                    var urlDestino = 'interfaz_usua.php';
                    window.location.href = urlDestino;
                }
            </script>
            <script>
                function validarFormulario() {
                    // Obtener la fecha y hora actuales
                    var fechaActual = new Date().toISOString().split('T')[0];
                    var horaActual = new Date().toLocaleTimeString('en-US', { hour12: false });

                    // Obtener los valores de fecha y hora del formulario
                    var fechaFormulario = document.getElementById('fecha').value;
                    var horaFormulario = document.getElementById('hora').value;

                    // Validar que la fecha no sea anterior a la actual
                    if (fechaFormulario < fechaActual) {
                        alert('La fecha no puede ser anterior al día actual.');
                        return false;
                    }

                    if (horaFormulario >= '21:30' || horaFormulario < '08:00') {
                        alert('La hora debe estar entre las 08:00 AM y las 21:30.');
                        return false;
                    }

                    // Otras validaciones que puedas necesitar...

                    // Si todas las validaciones son exitosas, puedes enviar el formulario
                    return true;
                }
                // JavaScript para ocultar el mensaje después de 2 segundos
                setTimeout(function() {
                    var mensaje = document.getElementById('mensaje');
                    if (mensaje) {
                        mensaje.style.display = 'none';
                    }
                }, 2000); // 2000 milisegundos = 2 segundos
            </script>
        </form>
    </div>
    <div class="calendario">
        <div id="calendar-container">
            <!-- Contenedor del calendario generado dinámicamente por PHP -->
            <?php include 'calendario.php'; ?>
        </div>
        <div id="event-details-container">
            <!-- Contenedor para mostrar detalles del evento seleccionado -->
        </div>
    </div>
</div>



<!-- Cuerpo de la pagina -->

            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Barber Shop 593 2023</div>
                    <div>
                        <a href="#">política de privacidad</a>
                        &middot;
                        <a href="#">Condiciones &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>
</html>


