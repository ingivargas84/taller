//Cliente
$(document).ready(function() {
    $('#direccion').val("");
    $('#telefono').val("");
    $('#correo').val("");
    $('#cliente_id option')[0].selected = 'selected';
});

$("#cliente_id").select2();
$("#cliente_id").change(function () {
    $('#direccion').val("");
    $('#telefono').val("");
    $('#correo').val("");
    console.log($('#cliente_id option:selected').val());
    $.getJSON('/misRutas/clientes/' + $('#cliente_id option:selected').val(), function (data) {
        $('#direccion').val(data[0].direccion);
        $('#correo').val(data[0].correo_electronico);
        $('#telefono').val(data[0].telefono);
    });
});

$.validator.addMethod("notDefault", function (value) {
    if (value == '0') {
        return false;
    } else {
        return true;
    }
}, 'Por favor, eliga una opción');

var validator = $("#misRutasForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        cliente_id: {
            required: true,
            notDefault: true,
        },
        observaciones: {
            required: true,
        },
       
    },
    messages: {
        cliente_id: {
            required: "Seleccione un cliente",
            notDefault: "Primero selecione un cliente"
        },
        observaciones: {
            required: "Ingrese el motivo de visita",
        },
    }
});

$("#ButtonMisRutas").click(function (event) {
    if ($('#misRutasForm').valid()) {
        $('.loader').addClass("is-active");
    } else {
        validator.focusInvalid();
    }
});
