//
$('#fecha').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy'
});
//
$.validator.addMethod("onlyPInteger", function (value) {
    var regX = /^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/;
    if (regX.test(value.trim()) == false) {
        $(this).val('');
        return false;
    } else {
        return true;
    }
});

//Cheque emitido
$.validator.addMethod("chequeEmitido", function (value, element) {
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: "chequeEmitido",
        data: {
            "numero": value, 
            "cuentaID": $('#cuentaId').val()
        },
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "El cheque ya fue emitido anteriormente");


$.validator.addMethod("notDefault", function (value) {
    if (value == '0') {
        return false;
    } else {
        return true;
    }
}, 'Por favor, eliga una opción');

var validator = $("#ChequeForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        fecha: {
            required: true,
        },
        cantidad: {
            required: true,
            number: true,
            onlyPInteger: true,
        },
        no_cheque: {
            required: true,
            number: true,
            chequeEmitido: true,
        },
        desc: {
            required: true
        },
        receptor: {
            required: true
        },
        ref: {
            required: true
        },
        persona_acepta: {
            required: true
        },
        cuenta_bancaria_id: {
            required: true,
            notDefault: true,

        }

    },
    messages: {
        fecha: {
            required: "Por favor, ingrese la fecha",
        },
        cantidad: {
            required: "Por favor, ingrese la cantidad",
            number: "Ingrese formato válido",
            onlyPInteger: "Ingrese solo números positivos",
        },
        no_cheque: {
            required: "Por favor, ingrese el No. Cheque",
            number: "Ingrese solo números",
        },
        desc: {
            required: "Por favor, ingrese la descripción"
        },
        receptor: {
            required: "Por favor, ingrese el receptor"
        },
        ref: {
            required: "Por favor, ingrese la referencia"
        },
        persona_acepta: {
            required: "Por favor, ingrese la persona"
        },
        cuenta_bancaria_id: {
            required: "Por favor, ingrese la cuenta bancaria",

        }

    }
});

$("#cuenta_bancaria_id").change(function (event) {
    $('#cuentaId').val($("#cuenta_bancaria_id option:selected").val());
    console.log($("#cuenta_bancaria_id option:selected").val());
});

$("#ButtonCheque").click(function (event) {
    if ($('#ChequeForm').valid()) {
        $('.loader').addClass("is-active");
    } else {
        validator.focusInvalid();
    }
});