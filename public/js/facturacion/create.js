//
//Funcion para validar NIT

function nitIsValid(nit) {
    if (!nit) {
        return true;
    }

    var nitRegExp = new RegExp('^[0-9]+(-?[0-9kK])?$');

    if (!nitRegExp.test(nit)) {
        return false;
    }

    nit = nit.replace(/-/, '');
    var lastChar = nit.length - 1;
    var number = nit.substring(0, lastChar);
    var expectedCheker = nit.substring(lastChar, lastChar + 1).toLowerCase();

    var factor = number.length + 1;
    var total = 0;

    for (var i = 0; i < number.length; i++) {
        var character = number.substring(i, i + 1);
        var digit = parseInt(character, 10);

        total += (digit * factor);
        factor = factor - 1;
    }

    var modulus = (11 - (total % 11)) % 11;
    var computedChecker = (modulus == 10 ? "k" : modulus.toString());

    return expectedCheker === computedChecker;
}

//Metodo NIT

$.validator.addMethod("nit", function (value, element) {
    var valor = value;

    if (nitIsValid(valor) == true) {
        return true;
    }

    else {
        return false;
    }
}, "El NIT ingresado es incorrecto o inválido, reviselo y vuelva a ingresarlo");



//Num unico
$.validator.addMethod("numUnico", function (value, element) {
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: urlActual + "/numDisponible",
        data: "no_factura=" + value,
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "El número de Factura ya está registrado en el sistema");
//
//Serie unica
$.validator.addMethod("facturaUnica", function (value, element) {
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    var num_factura = $("input[name='no_factura']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: urlActual + "/facturaDisponible",
        data: {
            "serie=" : value,
            "no_factura=" : num_factura,
        },
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "La factura ya está registrada en el sistema");


//validate
var validator = $("#facturaForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    //onfocusout: false,
    rules: {
        serie: {
            required: true,
            facturaUnica: true
        },
        no_factura: {
            required: true
        },
        direccion: {
            required: true,
        },
        cliente: {
            required: true,
        },
        nit: {
            required: true,
            nit: true,
        }

    },
    messages: {
        no_factura: {
            required: "Por favor, ingrese el número de Factura",
        },
        serie: {
            required: "Por favor, ingrese la serie en la Factura",
        },
        direccion: {
            required: "Ingrese la dirección o deje por defecto 'Ciudad'"
        },
        cliente: {
            required: "Ingrese el nombre del cliente",
        },
        nit: {
            required: "Ingrese el nit"
        }

    }
});

function getClient() {
    $('#cliente').prop('disabled', false);
    $('#nit').prop('disabled', false);

    $.getJSON('/clienteOrden/' + $('#ordenes').val(), function (data) {
        $.each(data, function () {
            $('#cliente').val(this.nombre_comercial);
            $('#nit').val(this.nit);
            $('#idCliente').val(this.id);
        });
    });
}

function checkCustomer() {
    

    if ($('#isCustomer').val() == 1) {
        getClient();
        $('#ordenes').on('change', function () {
            //$("#isCustomer option[value='1']").pro('selected', 'selected');
            getClient();
        });
    } else {
        $('#ordenes').on('change', function () {
            $("#isCustomer option[value='1']").prop('selected', 'selected');

        });
        $('#cliente').val("");
        $('#nit').val("");
        $('#idCliente').val("");
        $('#cliente').prop('disabled', true);
        $('#nit').prop('disabled', true);

    }
}
//Logica para mostrar el cliente
$('#facturaModal').click().on('shown.bs.modal', function (event) {
    
    checkCustomer();
    $('#isCustomer').on('change',function(){
        checkCustomer();
    });
    
 });




//Acción Guardar 
$("#ButtonFacturaModal").click(function (event) {
    event.preventDefault();
    if ($('#facturaForm').valid()) {
        saveModal();
    } else {
        validator.focusInvalid();
    }
});


//Guardar un nuevo registro
function saveModal(button) {
    var formData = $("#facturaForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#facturaForm').val() },
        url: urlActual + "/save",
        data: formData,
        dataType: "json",
        success: function (data) {
            window.location.href = urlActual;
            //alertify.set('notifier', 'position', 'top-center');
            //alertify.success('La factura fue registrada con Éxito!!');

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#facturaForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}



//Mostrar y ocultar formulario
if (window.location.hash === '#create') {
    $('#facturaModal').modal('show');
}

$('#facturaModal').on('hide.bs.modal', function () {
    $("#facturaForm").validate().resetForm();
    document.getElementById("facturaForm").reset();
    window.location.hash = '#';

});

$('#facturaModal').on('shown.bs.modal', function () {
    window.location.hash = '#create';

}); 

