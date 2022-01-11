$.validator.addMethod("notDefault", function (value) {
    if (value == '0') {
        return false;
    } else {
        return true;
    }
}, 'Por favor, eliga una opción');

var validator = $("#EnvioForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        receptor: {
            required: true,
        },
        direccion: {
            required: true,
        },
        empleado_genera_id: {
            required: true,
            notDefault: true,
        },
        equipo_id: {
            required: true,
            notDefault: true,
        },
    },
    messages: {
        receptor: {
            required: "Ingrese el receptor",
        },
        direccion: {
            required: "Ingrese la dirección",
        },
        empleado_genera_id: {
            required: "Seleccione un empleado",
            notDefault: "Seleccione un empleado",
        },
        equipo_id: {
            required: "Seleccione un equipo",
            notDefault: "Seleccione una orden equipo",
        },

    }
});

$('#equipo_id').change(function(value) {
    $('#equipo').val("");
    $.getJSON('/enviosEquipo/getOrdenEquipo/' + $('#equipo_id option:selected').val(), function (data) {
        $('#equipo').val(data[0].equipo.equipo);
    });
});

$("#ButtonEnvio").click(function (event) {
    if ($('#EnvioForm').valid()) {
        $('.loader').addClass("is-active");
    } else {
        validator.focusInvalid();
    }
});

$(document).ready(function () {
    $('#equipo').val("");
});
