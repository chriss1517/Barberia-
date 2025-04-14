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
    <link href="../styles/inicio.css" rel="stylesheet" />
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
                    <div class="welcome-message">
                        <h1>¡Bienvenido/a, <?php echo $nombre_usuario; ?>!</h1>
                        <p>Gracias por iniciar sesión. Esperamos que disfrutes tu experiencia en Barber Shop 593.</p>
                    </div>
                    <div class="container">
        <div class="row">
            <!-- Icono para agendar -->
            <div class="col-xl-3 col-md-6">
                <a href="interfaz_usua1.php" class="icon-card bg-success">
                    <div class="icon"><i class="far fa-calendar-plus"></i></div>
                    <div class="description">Agendar</div>
                </a>
            </div>
        </div>
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
</body>
</html>
