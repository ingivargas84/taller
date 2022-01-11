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
}, "El nombre del estado de taller ya está registrado en el sistema");


//validate
var validator = $("#estadosTallerForm").validate({
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
            required: "Por favor, ingrese el estado de taller"
        }
    }
});
//Acción Guardar 
$("#ButtonEstadosTallerModal").click(function (event) {
    event.preventDefault();
    if ($('#estadosTallerForm').valid()) {
        saveModal();
    } else {
        validator.focusInvalid();
    }
});

//Guardar un nuevo registro
function saveModal(button) {
    var formData = $("#estadosTallerForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#estadosTallerForm').val() },
        url: urlActual + "/save",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#estadosTallerModal').modal('hide');
            estadosTallerTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('Estado de taller creado con Éxito!!');

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#estadosTallerForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}

//Mostrar y ocultar formulario
if (window.location.hash === '#create') {
    $('#estadosTallerModal').modal('show');
}

$('#estadosTallerModal').on('hide.bs.modal', function () {
    $("#estadosTallerForm").validate().resetForm();
    document.getElementById("estadosTallerForm").reset();
    window.location.hash = '#';

});

$('#estadosTallerModal').on('shown.bs.modal', function () {
    window.location.hash = '#create';

}); 