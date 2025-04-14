<?php
include '../interfazadmin/sesiones.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="../img/logo.png" >
    <title>Barber shop 593 - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../styles/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        /* Estilos para la búsqueda */
        .search-form {
            margin-bottom: 20px;
        }
        /* Estilos para la tabla */
        .table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="interfaz_admin.php">Barber Shop 593</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <ul class="navbar-nav ms-auto me-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user"></i> <?php echo $nombre_usuario; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Configuración</a></li>
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
                    <a class="nav-link" href="../interfazadmin/interfaz_admin.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Panel   
                    </a>
                    <div class="sb-sidenav-menu-heading">Interfaz</div>
                    <a class="nav-link" href="../interfazadmin/interfaz_admin1.php">
                        <div class="sb-nav-link-icon"><i class="far fa-calendar"></i></div>
                        <span>Visualizar Agenda</span>
                    </a>
                    <a class="nav-link" href="../interfazadmin/interfaz_admin2.php">
                        <div class="sb-nav-link-icon"><i class="far fa-file-alt"></i></div>
                        <span>Generar Reporte</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
    <main>
    <div class="container py-5">
        <h1 class="text-center mb-4">Agenda</h1>
        <!-- Formulario para buscar por fecha -->
        <form class="search-form mb-4" method="GET" action="">
            <div class="row">
                <div class="col-md-6">
                    <label for="fecha" class="form-label">Buscar por fecha:</label>
                    <input type="date" id="fecha" name="fecha" class="form-control" value="<?php echo isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d'); ?>">
                </div>
                <div class="col-md-6 mt-4">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Mostrar los datos de la tabla turnos -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Tipo de Servicio</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Obtener la fecha seleccionada del formulario
                    $fechaSeleccionada = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

                    // Consultar los datos de la tabla turnos para la fecha seleccionada
                    $sql = "SELECT turnos.*, usuarios.nombre AS cliente FROM turnos INNER JOIN usuarios ON turnos.id_usuario = usuarios.id_usuario WHERE fecha = '$fechaSeleccionada' ORDER BY fecha ASC, hora ASC";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["cliente"] . "</td>";
                            echo "<td>" . $row["tiposervicio"] . "</td>";
                            echo "<td>" . $row["fecha"] . "</td>";
                            echo "<td>" . $row["hora"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay turnos registrados para la fecha seleccionada.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
</body>
</html>
