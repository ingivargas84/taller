$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $('#IngresoCompusForm').validate({
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
        razon_ingreso: {
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
        razon_ingreso: {
            required: "Este campo es obligatorio."
        }
    }
});

