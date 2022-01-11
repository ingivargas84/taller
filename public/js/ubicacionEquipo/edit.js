//Actualizar
function updateModal(button) {
    var formData = $("#ubicacionEquipoUpdateForm").serialize();
    var id = $("input[name='id']").val();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "PUT",
        headers: { 'X-CSRF-TOKEN': $('#ubicacionEquipoEditToken').val() },
        url: urlActual + "/" + id + "/update",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            BorrarFormularioUpdate();
            $('#ubicacionEquipoUpdateModal').modal("hide");
            ubicacionEquipoTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('Ubicación de equipo editada con Éxito!!');
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.email != null) {
                $("#ubicacionEquipoUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>" + errors.email + "</label>");
            }
            else {
                $("#ErrorNombreedit").remove();
            }
        }

    });
}

//Guardar
$("#ButtonUbicacionEquipoModalUpdate").click(function (event) {
    event.preventDefault();
    if ($('#ubicacionEquipoUpdateForm').valid()) {
        updateModal();
    } else {
        validator.focusInvalid();
    }
});


//Mostrar modal 
$('#ubicacionEquipoUpdateModal').on('shown.bs.modal', function (event) {
    
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var nombre = button.data('nombre');
    
    var modal = $(this);
    modal.find(".modal-body input[name='id']").val(id);
    modal.find(".modal-body input[name='nombre']").val(nombre);

});

//validate
$.validator.addMethod("nombreUnico", function (value, element) {
    var valid = false;
    var id = $("input[name='id']").val();
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: urlActual + "/nombreDisponibleEdit",
        data: { "nombre": value, "id": id },
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "La ubicación ya está registrada en el sistema");

var validator = $("#ubicacionEquipoUpdateForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    onkeypress: true,
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




//Eliminar data de form
function BorrarFormularioUpdate() {
    $("#ubicacionEquipoUpdateForm :input").each(function () {
        $(this).val('');
    });
};


//Cambio de url para editar
if (window.location.hash === '#edit') {
    $('#ubicacionEquipoUpdateModal').modal('show');
}

$('#ubicacionEquipoUpdateModal').on('hide.bs.modal', function () {
    $("#ubicacionEquipoUpdateForm").validate().resetForm();
    document.getElementById("ubicacionEquipoUpdateForm").reset();
    window.location.hash = '#';

});

$('#ubicacionEquipoUpdateModal').on('shown.bs.modal', function () {
    window.location.hash = '#edit';

}); 