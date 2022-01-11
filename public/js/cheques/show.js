//Mostrar y ocultar formulario
if (window.location.hash === '#show') {
    $('#infoCheque').modal('show');
}

$('#infoCheque').on('hide.bs.modal', function () {
    window.location.hash = '#';
    $('#detalle').empty();
    $('#info1').empty();
    $('#info2').empty();
    $('#info3').empty();
    $('#info4').empty();
    $('#info5').empty();
    $('#info6').empty();
    $('#info7').empty();
    $('#info8').empty();
    $('#info9').empty();
 
});

$('#infoCheque').on('shown.bs.modal', function () {
    window.location.hash = '#show';

}); 

//Mostrar modal 
$('#infoCheque').on('shown.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    $.getJSON('/cheque/' + id, function (data) {
        $('#detalle').append(data[0].no_cheque);
        $('#info1').append(data[0].fecha);
        $('#info2').append(data[0].cantidad);
        $('#info3').append(data[0].descripcion);
        $('#info4').append(data[0].receptor);
        $('#info5').append(data[0].referencia);
        $('#info6').append(data[0].usuario.name);
        $('#info7').append(data[0].persona_acepta);
        $('#info8').append(data[0].cuenta_bancaria.nombre_cuenta + "-" + data[0].cuenta_bancaria.no_cuenta + ", " + data[0].cuenta_bancaria.banco.banco );
        $('#info9').append(data[0].estado_cheque.estado);

    });

    var modal = $(this);
});