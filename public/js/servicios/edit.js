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
}, "El nombre del servicio ya está registrado en el sistema");

var validator = $("#servicioUpdateForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    //onfocusout: false,
    rules: {
        nombre: {
            required: true,
            nombreUnico: true
        },
        precio: {
            required: true,
            number: true,
            min: true,
        }

    },
    messages: {
        nombre: {
            required: "Por favor, ingrese el nombre del servicio"
        },

        precio: {
            required: "Por favor, ingrese el precio del servicio",
            number: 'Ingrese solamente números',
            min: 'Ingrese números positivos',
        },

    }
});

$('#servicioModalUpdate').on('shown.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var nombre = button.data('nombre');
    var precio = button.data('desc');
    var modal = $(this);
    modal.find(".modal-body input[name='id']").val(id);
    modal.find(".modal-body input[name='nombre']").val(nombre);
    modal.find(".modal-body input[name='precio']").val(precio);

});

function BorrarFormularioUpdate() {
    $("#servicioUpdateForm :input").each(function () {
        $(this).val('');
    });
};

$("#buttonServicioModalUpdate").click(function (event) {
    event.preventDefault();
    if ($('#servicioUpdateForm').valid()) {
        updateModal();
    } else {
        validator.focusInvalid();
    }
});

function updateModal(button) {
    var formData = $("#servicioUpdateForm").serialize();
    var id = $("input[name='id']").val();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "PUT",
        headers: { 'X-CSRF-TOKEN': $('#servicioEditToken').val() },
        url: urlActual + "/" + id + "/update",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            BorrarFormularioUpdate();
            $('#servicioModalUpdate').modal("hide");
            servicios_table.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('Servicio Editado con Éxito!!');
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.email != null) {
                $("#servicioUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>" + errors.email + "</label>");
            }
            else {
                $("#ErrorNombreedit").remove();
            }
        }

    });
}

if (window.location.hash === '#edit') {
    $('#servicioModalUpdate').modal('show');
}

$('#servicioModalUpdate').on('hide.bs.modal', function () {
    $("#servicioUpdateForm").validate().resetForm();
    document.getElementById("servicioUpdateForm").reset();
    window.location.hash = '#';

});

$('#servicioModalUpdate').on('shown.bs.modal', function () {
    window.location.hash = '#edit';

});


/*$(".edit-user").click(function(){
	alert($(".edit-user").attr("data-id"));
	console.log('si');

});*/




