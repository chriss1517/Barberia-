<?php
if (isset($_POST['fecha'])) {
    // Conectar a la base de datos
    $pdo = new PDO('mysql:host=localhost;dbname=barbershop', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Habilitar el manejo de excepciones
    $pdo->exec("set names utf8");

    // Obtener detalles del evento para la fecha seleccionada
    $fecha = $_POST['fecha'];
    $stmt = $pdo->prepare("SELECT hora FROM turnos WHERE fecha = :fecha ORDER BY hora");
    $stmt->bindParam(':fecha', $fecha);
    $stmt->execute();
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar detalles del evento
    if ($eventos) {
        echo '<div id="event-details-container">';
        echo '<button style="color: white; background-color: red;" onclick="cerrarDetallesEvento()">X</button>';
        echo '<h3>Horas Ocupadas:</h3>';
        echo '<ul>';
        foreach ($eventos as $evento) {
            echo '<li>Hora: ' . $evento['hora']. '</li>';
        }
        echo '</ul>';
        echo '</div>';
    } else {
        echo '<div id="event-details-container">'; 
        echo '<button style="color: white; background-color: red;" onclick="cerrarDetallesEvento()">X</button>';
        echo '<p>No hay turnos programados para esta fecha.</p>';
        echo '</div>';
    }
} else {
    echo '<div id="event-details-container">';
    echo '<button style="color: white; background-color: red;" onclick="cerrarDetallesEvento()">X</button>';
    echo '<p>Error al cargar detalles del turno.</p>';
    echo '</div>';
}
?>
<script>
    function cerrarDetallesEvento() {
        var detallesContainer = document.getElementById("event-details-container");
        detallesContainer.innerHTML = ""; // Limpiar el contenido
    }
</script>
