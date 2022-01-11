//Mostrar modal 
$('#tipoTrabajoUpdateModal').on('shown.bs.modal', function (event) {
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
}, "El tipo de trabajo ya está registrado en el sistema");

var validator = $("#tipoTrabajoUpdateForm").validate({
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

//Actualizar
function updateModal(button) {
    var formData = $("#tipoTrabajoUpdateForm").serialize();
    var id = $("input[name='id']").val();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "PUT",
        headers: { 'X-CSRF-TOKEN': $('#tipoTrabajoEditToken').val() },
        url: urlActual + "/" + id + "/update",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            BorrarFormularioUpdate();
            $('#tipoTrabajoUpdateModal').modal("hide");
            tipoTrabajoTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('Tipo de trabajo editado con Éxito!!');
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.email != null) {
                $("#tipoTrabajoUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>" + errors.email + "</label>");
            }
            else {
                $("#ErrorNombreedit").remove();
            }
        }

    });
}

//Guardar

$("#ButtonTipoTrabajoModalUpdate").click(function (event) {
    event.preventDefault();
    if ($('#tipoTrabajoUpdateForm').valid()) {
        updateModal();
    } else {
        validator.focusInvalid();
    }
});

//Eliminar data de form
function BorrarFormularioUpdate() {
    $("#tipoTrabajoUpdateForm :input").each(function () {
        $(this).val('');
    });
};


//Cambio de url para editar
if (window.location.hash === '#edit') {
    $('#tipoTrabajoUpdateModal').modal('show');
}

$('#tipoTrabajoUpdateModal').on('hide.bs.modal', function () {
    $("#tipoTrabajoUpdateForm").validate().resetForm();
    document.getElementById("tipoTrabajoUpdateForm").reset();
    window.location.hash = '#';

});

$('#tipoTrabajoUpdateModal').on('shown.bs.modal', function () {
    window.location.hash = '#edit';

}); 