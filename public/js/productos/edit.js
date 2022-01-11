
//validate
$.validator.addMethod("nombreUnico", function (value, element) {
    var valid = false;
    var id = $("input[name='id']").val();
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: "/productos/nombreDisponibleEdit/",
        data: { "producto": value, "id": id },
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "El producto ya está registrada en el sistema");

//
$.validator.addMethod("codigoUnico", function (value, element) {
    var valid = false;
    var id = $("input[name='id']").val();
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: "/productos/codigoDisponibleEdit/",
        data: { "codigo": value, "id": id },
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "El código del producto ya está registrado en el sistema");


$("#productoUpdateButton").click(function (event) {
    if ($('#productoUpdateForm').valid()) {
        $('.loader').addClass("is-active");
    } else {
        validator.focusInvalid();
    }
});

$.validator.addMethod("min", function (value) {
    if (value > 0) {
        return true;
    } else {
        return false;
    }
});

//
var validator = $('#productoUpdateForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        codigo: {
            required: true,
            codigoUnico: true,
        },
        producto: {
            required: true,
            nombreUnico: true,
        },
        stock_minimo: {
            required: true,
           
            min: true,
        },
        stock_maximo: {
            required: true,
           
            min: true,
        },
        precio_venta: {
            required: true,
          
        },

    },
    messages: {
        codigo: {
            required: "Por favor, ingrese un código",
        },
        producto: {
            required: "Por favor, ingrese el nombre del producto",
        },
        stock_minimo: {
            required: "Por favor, ingrese el stock mínimo",
            min: 'Por favor, ingrese un número mayor o igual a 1',
            number: 'Ingrese solo números',
        },
        stock_maximo: {
            required: "Por favor, ingrese el stock máximo",
            min: 'Por favor, ingrese un número mayor o igual a 1',
            number: 'Ingrese solo números',
        },
        precio_venta: {
            required: "Por favor, ingrese el precio de venta",
            number: 'Ingrese solo números',
        },
    }
});