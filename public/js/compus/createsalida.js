$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $('#SalidaCompusForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        equipo_id: {
            required: true,
            select: 'default'
        },
        tatuaje: {
            required: true,
        },
        razon_salida: {
            required: true,
        }
    },
    messages: {
        equipo_id: {
            required: "Este campo es obligatorio."
        },
        tatuaje: {
            required: "Este campo es obligatorio."
        },
        razon_salida: {
            required: "Este campo es obligatorio."
        }
    }
});

