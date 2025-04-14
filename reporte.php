<?php
require('../fpdf/fpdf.php'); // Asegúrate de tener el archivo fpdf.php en el mismo directorio

// Establecer el locale en español
setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES.utf8', 'esp');

// Incluir el archivo de conexión
include '../conexion/conexion.php';

// Clase extendida de FPDF para generar el reporte
class PDF extends FPDF
{
    private $fechaReporte;

    // Modificar la función setFechaReporte() para incluir el año
    function setFechaReporte($fecha) {
        $this->fechaReporte = strftime("%A, %d de %B del %Y", strtotime($fecha));
    }

    // Cabecera del reporte
    function Header() {
        // Título
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 14, 'Barber Shop 593', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 5, 'Av. Guayas y Pedro Carbo, Tel: 0991267661', 0, 1, 'C');
        $this->Ln(10);

        // Ajustar la posición del texto "Reporte Del" más abajo
        $this->Cell(0, -10, '', 0, 1); // Agregar un espacio en blanco para bajar la posición
        // Agregar la fecha del reporte en español
        $this->SetFont('Arial', 'B', 14); // Aumentar el tamaño y hacer negrita
        $this->Cell(0, 14, 'Reporte Del ' . $this->fechaReporte, 0, 1, 'C');
        $this->SetFont('Arial', '', 12); // Restaurar la fuente normal
        $this->Ln(10);
        
        // Encabezados de la tabla
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(60, 10, 'Cliente', 1, 0, 'C'); // Cambiado el ancho de la columna para el nombre del cliente
        $this->Cell(60, 10, 'Tipo de Servicio', 1, 0, 'C');
        $this->Cell(40, 10, 'Fecha', 1, 0, 'C');
        $this->Cell(30, 10, 'Hora', 1, 1, 'C');
    }

    // Cuerpo del reporte
    function TablaReporte($data)
    {
        $this->SetFont('Arial', '', 10);

        foreach ($data as $row) {
            $this->Cell(60, 10, $row['nombre_cliente'], 1, 0, 'C'); // Mostrar el nombre del cliente en lugar del ID de usuario
            $this->Cell(60, 10, $row['tiposervicio'], 1, 0, 'C');
            $this->Cell(40, 10, $row['fecha'], 1, 0, 'C');
            $this->Cell(30, 10, $row['hora'], 1, 1, 'C');
        }
    }
}

// Recuperar la fecha seleccionada del formulario
if (isset($_GET['fecha'])) {
    $fechaSeleccionada = $_GET['fecha'];

    // Realizar la consulta para obtener los datos de la tabla turnos
    $sql = "SELECT tiposervicio, fecha, hora, id_usuario FROM turnos WHERE fecha = '$fechaSeleccionada' ORDER BY hora";
    $result = $conn->query($sql);

    // Crear un array con los datos obtenidos de la tabla turnos
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Obtener el nombre del cliente a partir del ID de usuario
            $idUsuario = $row['id_usuario'];
            $sql_cliente = "SELECT nombre FROM usuarios WHERE id_usuario = '$idUsuario'";
            $result_cliente = $conn->query($sql_cliente);
            $row_cliente = $result_cliente->fetch_assoc();
            $nombreCliente = $row_cliente['nombre'];

            // Agregar el nombre del cliente al array de datos
            $row['nombre_cliente'] = $nombreCliente;

            // Agregar el registro al array de datos
            $data[] = $row;
        }
    }

    // Crear un objeto de tipo PDF
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->setFechaReporte($fechaSeleccionada); // Aquí se establece la fecha del reporte
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    // Generar la tabla en el reporte
    $pdf->TablaReporte($data);

    // Salida del PDF
    $pdf->Output();
}
?>
