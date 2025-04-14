<?php
// Conectar a la base de datos
$pdo = new PDO('mysql:host=localhost;dbname=barbershop', 'root', '');
$pdo->exec("set names utf8");

// Obtener el mes y el año actuales o desde la URL si se proporcionan
$mes = isset($_GET['mes']) ? $_GET['mes'] : date('m');
$anio = isset($_GET['anio']) ? $_GET['anio'] : date('Y');

// Obtener eventos de la base de datos para el mes actual
$primerDiaMes = date("Y-m-01", strtotime("$anio-$mes-01"));
$ultimoDiaMes = date("Y-m-t", strtotime("$anio-$mes-01"));

$stmt = $pdo->prepare("SELECT * FROM turnos WHERE fecha BETWEEN :primerDiaMes AND :ultimoDiaMes");
$stmt->bindParam(':primerDiaMes', $primerDiaMes);
$stmt->bindParam(':ultimoDiaMes', $ultimoDiaMes);
$stmt->execute();
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Crear un array asociativo de eventos con fechas como claves
$eventosPorFecha = [];
foreach ($eventos as $evento) {
    $fecha = $evento['fecha'];
    $eventosPorFecha[$fecha][] = $evento;
}

// Generar el calendario
echo '<div id="calendar-header">';
echo '<a href="?mes=' . date('m', strtotime('-1 month', strtotime("$anio-$mes-01"))) . '&anio=' . date('Y', strtotime('-1 month', strtotime("$anio-$mes-01"))) . '">Mes Anterior</a>';
echo '<h2>' . date('F Y', strtotime("$anio-$mes-01")) . '</h2>';
echo '<a href="?mes=' . date('m', strtotime('+1 month', strtotime("$anio-$mes-01"))) . '&anio=' . date('Y', strtotime('+1 month', strtotime("$anio-$mes-01"))) . '">Mes Siguiente</a>';
echo '</div>';

echo '<div id="calendar-body">';
echo '<div class="day-name">Domingo</div>';
echo '<div class="day-name">Lunes</div>';
echo '<div class="day-name">Martes</div>';
echo '<div class="day-name">Miércoles</div>';
echo '<div class="day-name">Jueves</div>';
echo '<div class="day-name">Viernes</div>';
echo '<div class="day-name">Sábado</div>';

// Obtener el día de la semana del primer día del mes
$diaSemana = date('w', strtotime($primerDiaMes));

// Rellenar los días vacíos al principio del mes
for ($i = 0; $i < $diaSemana; $i++) {
    echo '<div class="empty-day"></div>';
}

// Generar los días del mes
for ($i = 1; $i <= date('t', strtotime("$anio-$mes-01")); $i++) {
    $fechaActual = date("Y-m-d", strtotime("$anio-$mes-$i"));
    $claseDia = (isset($eventosPorFecha[$fechaActual])) ? 'day event' : 'day';
    echo '<div class="' . $claseDia . '" data-fecha="' . $fechaActual . '">' . $i . '</div>';
}

echo '</div>';

?>
