$.validator.addMethod("min", function (value) {
    if (value.trim() > 0) {
        return true;
    } else {
        return false;
    }
});

//
$.validator.addMethod("nombreUnico", function (value, element) {
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: "/productos/nombreDisponible/",
        data: "producto=" + value,
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "El producto ya está registrado en el sistema");

//
//
$.validator.addMethod("codigoUnico", function (value, element) {
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url:  "/productos/codigoDisponible/",
        data: "codigo=" + value,
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "El código del producto ya está registrado en el sistema");

//
$.validator.addMethod("greaterThen", function (value, element) {
    var minimo = $("#stock_minimo").val();
    var maximo = $("#stock_maximo").val();
    
    if (parseFloat(minimo) < parseFloat(maximo)) {
        return true;
    } else {
        return false;
    }
}, "Ingrese un numero más alto que el stock mínimo");

//
var validator = $('#productoForm').validate({
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
            number: true,
            min: true,
        },
        stock_maximo: {
            required: true,
            number: true,
            min: true,
            greaterThen: true,

        },
        precio_venta: {
            required: true,
            number: true,
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