var validator = $("#envioModalForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        receptor_modal: {
            required: true,
        },
    },
    messages: {
        receptor_modal: {
            required: "Ingrese el receptor",
        },

    }
});

$("#ButtonEnvioModal").click(function (event) {
    if ($('#envioModalForm').valid()) {
        $('.loader').addClass("is-active");
    } else {
        validator.focusInvalid();
    }
});

//
//Mostrar y ocultar formulario
if (window.location.hash === '#entregado') {
    $('#envioModal').modal('show');

}

$('#envioModal').on('hide.bs.modal', function () {
    $("#envioModalForm").validate().resetForm();
    document.getElementById("envioModalForm").reset();
    window.location.hash = '#';
    $('#receptor_modal').empty();

});

$('#envioModal').on('shown.bs.modal', function (event) {
    window.location.hash = '#entregado';
    var button = $(event.relatedTarget);
    var id = button.data('id');
    $('#envioModalId').val(id);
    var receptor = button.data('receptor');
    $('#receptor_modal').val(receptor);

});


//Acción Guardar 
$("#ButtonEnvioModal").click(function (event) {
    event.preventDefault();
    if ($('#envioModalForm').valid()) {
        updateReceptor();
    } else {
        validator.focusInvalid();
    }
});

//Cambiar estado a entregado
function updateReceptor(button) {
    var formData = $("#envioModalForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "PUT",
        headers: { 'X-CSRF-TOKEN': $('#envioModalForm').val() },
        url: urlActual + "/entregar/" + $('#envioModalId').val(),
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#envioModal').modal('hide');
            enviosTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('El envío fue entregado con Éxito!!');

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#envioModalForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}
