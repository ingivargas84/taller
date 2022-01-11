$.validator.addMethod("notDefault", function (value) {
    if (value == '0') {
        return false;
    } else {
        return true;
    }
}, 'Por favor, eliga una opción');

var validator = $("#EnvioUpdateForm").validate({
        ignore: [],
        onkeyup: false,
        rules: {
            receptor_edit: {
                required: true,
            },
            direccion_edit: {
                required: true,
            },
            empleado_id_edit: {
                required: true,
                notDefault: true,
            },
            equipo_id_edit: {
                required: true,
                notDefault: true,
            },
        },
        messages: {
            receptor_edit: {
                required: "Ingrese el receptor",
            },
            direccion_edit: {
                required: "Ingrese la dirección",
            },
            empleado_id_edit: {
                required: "Seleccione un empleado",
                notDefault: "Seleccione un empleado",
            },
            equipo_id_edit: {
                required: "Seleccione un equipo",
                notDefault: "Seleccione una orden equipo",
            },

        }
  
});

$('#equipo_id_edit').change(function (value) {
    $('#equipo').val("");
    $.getJSON('/enviosEquipo/getOrdenEquipo/' + $('#equipo_id_edit option:selected').val(), function (data) {
        $('#equipo').val(data[0].equipo.equipo);
    });
});


$("#ButtonEnvioUpdate").click(function (event) {
    if ($('#EnvioUpdateForm').valid()) {
        $('.loader').addClass("is-active");
    } else {
        validator.focusInvalid();
    }
});

