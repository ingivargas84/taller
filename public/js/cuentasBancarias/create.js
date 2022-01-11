//validate
var validator = $("#cuentaForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    //onfocusout: false,
    rules: {
        nombre: {
            required: true,
        },
        no_cuenta: {
            required: true,
            number: true,
        },
        banco_id: {
            required: true,
        },
        tipo_cuenta: {
            required: true,
        }

    },
    messages: {
        nombre: {
            required: "Por favor, ingrese el nombre de la cuenta"
        },
        no_cuenta: {
            required: "Por favor, ingrese el no. de cuenta",
            number: "Ingrese unicamente numeros"
        },
        banco_id: {
            required: "Por favor, llene el campo",
        },
        tipo_cuenta: {
            required: "Por favor, seleccione el tipo de cuenta",
        }
    }
});


//Logica para mostrar los tipos de cuenta
$('#cuentaModal').click().on('shown.bs.modal', function (event) {
    $.getJSON('/tiposCuenta', function (data) {
        $.each(data, function () {
            $('#tipo_cuenta').append('<option value="' + this.id + '">' + this.tipo + '</option>');
        });
    });

    $.getJSON('/bancos', function (data) {
        $.each(data, function () {
            $('#banco_id').append('<option value="' + this.id + '">' + this.banco + '</option>');
        });
    });
});





//Acción Guardar 
$("#ButtonCuentaModal").click(function (event) {
    event.preventDefault();
    if ($('#cuentaForm').valid()) {
        saveModal();
    } else {
        validator.focusInvalid();
    }
});


//Guardar un nuevo registro
function saveModal(button) {
    var formData = $("#cuentaForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#cuentaForm').val() },
        url: urlActual + "/save",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#cuentaModal').modal('hide');
            cuentaTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('La cuenta fue creada con Éxito!!');

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#cuentaForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}



//Mostrar y ocultar formulario
if (window.location.hash === '#create') {
    $('#cuentaModal').modal('show');
}

$('#cuentaModal').on('hide.bs.modal', function () {
    $("#cuentaForm").validate().resetForm();
    document.getElementById("cuentaForm").reset();
    window.location.hash = '#';
    $('#tipo_cuenta').empty();
    $('#no_cuenta').empty();
    $('#banco_id').empty();
    $("input[name='nombre']").empty();
});

$('#cuentaModal').on('shown.bs.modal', function () {
    window.location.hash = '#create';

}); 