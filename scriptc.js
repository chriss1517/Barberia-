$(document).ready(function () {
    // Manejar clic en días con eventos
    $('.event').on('click', function () {
        var fecha = $(this).data('fecha');
        cargarDetallesEvento(fecha);
    });
});

function cargarDetallesEvento(fecha) {
    // Realizar una solicitud AJAX para obtener detalles del evento para la fecha seleccionada
    $.ajax({
        url: 'detalles_evento.php',
        type: 'POST',
        data: { fecha: fecha },
        dataType: 'html',
        success: function (response) {
            // Mostrar detalles del evento en el cuadro emergente
            $('#event-details-container').html(response);
            mostrarPopup();
        },
        error: function () {
            alert('Error al cargar detalles del evento.');
        }
    });
}

function mostrarPopup() {
    $('#event-popup').fadeIn();
}

function cerrarPopup() {
    $('#event-popup').fadeOut();
}
