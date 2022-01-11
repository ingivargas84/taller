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
}, "El nombre del tipo de trabajo ya está registrado en el sistema");


//validate
var validator = $("#TipoTrabajoForm").validate({
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
            required: "Por favor, ingrese el tipo de trabajo"
        }
    }
});
//Acción Guardar 
$("#ButtonTipoTrabajoModal").click(function (event) {
    event.preventDefault();
    if ($('#TipoTrabajoForm').valid()) {
        saveModal();
    } else {
        validator.focusInvalid();
    }
});

//Guardar un nuevo registro
function saveModal(button) {
    var formData = $("#TipoTrabajoForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#TipoTrabajoForm').val() },
        url: urlActual + "/save",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#tipoTrabajoModal').modal('hide');
            tipoTrabajoTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('Tipo de Trabajo creado con Éxito!!');

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#TipoTrabajoForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}

//Mostrar y ocultar formulario
if (window.location.hash === '#create') {
    $('#tipoTrabajoModal').modal('show');
}

$('#tipoTrabajoModal').on('hide.bs.modal', function () {
    $("#TipoTrabajoForm").validate().resetForm();
    document.getElementById("TipoTrabajoForm").reset();
    window.location.hash = '#';

});

$('#tipoTrabajoModal').on('shown.bs.modal', function () {
    window.location.hash = '#create';

}); 