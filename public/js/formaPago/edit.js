//Mostrar modal 
$('#formaPagoUpdateModal').on('shown.bs.modal', function (event) {
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
}, "La forma de pago ya está registrado en el sistema");

var validator = $("#formaPagoUpdateForm").validate({
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

//Actualizar
function updateModal(button) {
    var formData = $("#formaPagoUpdateForm").serialize();
    var id = $("input[name='id']").val();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "PUT",
        headers: { 'X-CSRF-TOKEN': $('#tokenFormaPagoEdit').val() },
        url: urlActual + "/" + id + "/update",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            BorrarFormularioUpdate();
            $('#formaPagoUpdateModal').modal("hide");
            formaPago.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('Forma de Pago editada con Éxito!!');
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.email != null) {
                $("#formaPagoUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>" + errors.email + "</label>");
            }
            else {
                $("#ErrorNombreedit").remove();
            }
        }

    });
}

//Guardar

$("#ButtonFormaPagoModalUpdate").click(function (event) {
    event.preventDefault();
    if ($('#formaPagoUpdateForm').valid()) {
        updateModal();
    } else {
        validator.focusInvalid();
    }
});

//Eliminar data de form
function BorrarFormularioUpdate() {
    $("#formaPagoUpdateForm :input").each(function () {
        $(this).val('');
    });
};


//Cambio de url para editar
if (window.location.hash === '#edit') {
    $('#formaPagoUpdateModal').modal('show');
}

$('#formaPagoUpdateModal').on('hide.bs.modal', function () {
    $("#formaPagoUpdateForm").validate().resetForm();
    document.getElementById("formaPagoUpdateForm").reset();
    window.location.hash = '#';

});

$('#formaPagoUpdateModal').on('shown.bs.modal', function () {
    window.location.hash = '#edit';

}); 