//Nombre unico
$.validator.addMethod("nombreUnico", function (value, element) {
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: urlActual + "/nombreDisponible",
        data: "nombre=" + value,
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "El nombre del puesto ya está registrado en el sistema");


//validate
var validator = $("#FormaPagoForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    //onfocusout: false,
    rules: {
        nombre: {
            required: true,
            nombreUnico: true
        }

    },
    messages: {
        nombre: {
            required: "Por favor, ingrese la forma de pago"
        }
    }
});
//Acción Guardar 
$("#ButtonFormaPagoModal").click(function (event) {
    event.preventDefault();
    if ($('#FormaPagoForm').valid()) {
        saveModal();    
    } else {
        validator.focusInvalid();
    }
});

//Guardar un nuevo registro
function saveModal(button) {
    var formData = $("#FormaPagoForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#tokenFormaPago').val() },
        url: urlActual + "/save",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#modalFormaPago').modal('hide');
            formaPago.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('Forma de Pago creado con Éxito!!');

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#FormaPagoForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}
//Mostrar y ocultar formulario
if (window.location.hash === '#create') {
    $('#modalFormaPago').modal('show');
}

$('#modalFormaPago').on('hide.bs.modal', function () {
    $("#FormaPagoForm").validate().resetForm();
    document.getElementById("FormaPagoForm").reset();
    window.location.hash = '#';
    
});

$('#modalFormaPago').on('shown.bs.modal', function () {
    window.location.hash = '#create';

}); 