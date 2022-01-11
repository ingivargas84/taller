//Mostrar modal 
$('#estadosTallerUpdateModal').on('shown.bs.modal', function (event) {
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
}, "El estado de taller ya está registrado en el sistema");

var validator = $("#estadosTallerUpdateForm").validate({
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

//Actualizar
function updateModal(button) {
    var formData = $("#estadosTallerUpdateForm").serialize();
    var id = $("input[name='id']").val();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "PUT",
        headers: { 'X-CSRF-TOKEN': $('#estadosTallerEditToken').val() },
        url: urlActual + "/" + id + "/update",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            BorrarFormularioUpdate();
            $('#estadosTallerUpdateModal').modal("hide");
            estadosTallerTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('Estado de taller editado con Éxito!!');
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.email != null) {
                $("#estadosTallerUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>" + errors.email + "</label>");
            }
            else {
                $("#ErrorNombreedit").remove();
            }
        }

    });
}

//Guardar

$("#ButtonEstadosTallerModalUpdate").click(function (event) {
    event.preventDefault();
    if ($('#estadosTallerUpdateForm').valid()) {
        updateModal();
    } else {
        validator.focusInvalid();
    }
});

//Eliminar data de form
function BorrarFormularioUpdate() {
    $("#estadosTallerUpdateForm :input").each(function () {
        $(this).val('');
    });
};


//Cambio de url para editar
if (window.location.hash === '#edit') {
    $('#estadosTallerUpdateModal').modal('show');
}

$('#estadosTallerUpdateModal').on('hide.bs.modal', function () {
    $("#estadosTallerUpdateForm").validate().resetForm();
    document.getElementById("estadosTallerUpdateForm").reset();
    window.location.hash = '#';

});

$('#estadosTallerUpdateModal').on('shown.bs.modal', function () {
    window.location.hash = '#edit';

}); 