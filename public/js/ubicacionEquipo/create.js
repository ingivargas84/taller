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
}, "La ubicación ya está registrada en el sistema");


//validate
var validator = $("#ubicacionEquipoForm").validate({
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
            required: "Por favor, ingrese la ubicación"
        }
    }
});
//Acción Guardar 
$("#ButtonUbicacionEquipoModal").click(function (event) {
    event.preventDefault();
    if ($('#ubicacionEquipoForm').valid()) {
        saveModal();
    } else {
        validator.focusInvalid();
    }
});

//Guardar un nuevo registro
function saveModal(button) {
    var formData = $("#ubicacionEquipoForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#ubicacionEquipoForm').val() },
        url: urlActual + "/save",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#ubicacionEquipoModal').modal('hide');
            ubicacionEquipoTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('La ubicación para trabajo creada con Éxito!!');

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#ubicacionEquipoForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}

//Mostrar y ocultar formulario
if (window.location.hash === '#create') {
    $('#ubicacionEquipoModal').modal('show');
}

$('#ubicacionEquipoModal').on('hide.bs.modal', function () {
    $("#ubicacionEquipoForm").validate().resetForm();
    document.getElementById("ubicacionEquipoForm").reset();
    window.location.hash = '#';

});

$('#ubicacionEquipoModal').on('shown.bs.modal', function () {
    window.location.hash = '#create';

}); 