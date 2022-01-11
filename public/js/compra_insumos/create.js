$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $('#CompraInsumosForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        proveedor_id: {
            required: true,
            select: 'default'
        },
        serie_factura: {
            required: true,
        },
        fecha_factura: {
            required: true,
        },
        num_factura: {
            required: true,
        }
    },
    messages: {
        proveedor_id: {
            required: "Este campo es obligatorio."
        },
        serie_factura: {
            required: "Este campo es obligatorio."
        },
        fecha_factura: {
            required: "Este campo es obligatorio."
        },
        num_factura: {
            required: "Este campo es obligatorio."
        }
    }
});

