//Actualizar
function updateModal(button) {
    var formData = $("#equipoUpdateForm").serialize();
    var id = $("input[name='id']").val();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "PUT",
        headers: { 'X-CSRF-TOKEN': $('#equipoUpdateToken').val() },
        url: urlActual + "/" + id + "/update",
        data: formData,
        dataType: "text",
        success: function (data) {
            $('.loader').fadeOut(225);
            BorrarFormularioUpdate();
            $('#equipoUpdateModal').modal("hide");
            equipoTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('Equipo editado con Éxito!!');
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.email != null) {
                $("#equipoUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>" + errors.email + "</label>");
            }
            else {
                $("#ErrorNombreedit").remove();
            }
        }

    });
}



$("#ButtonEquipoModalUpdate").click(function (event) {
    event.preventDefault();
    if ($('#equipoUpdateForm').valid()) {
       updateModal();
    } else {
        validator.focusInvalid();
    }
});

//Eliminar data de form
function BorrarFormularioUpdate() {
    $("#equipoUpdateForm :input").each(function () {
        $(this).val('');
    });
};

//validate
$.validator.addMethod("nombreUnico", function (value, element) {
    var valid = false;
    var id = $("input[name='id']").val();
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "POST",
        async: false,
        url: urlActual + "/nombreDisponibleEdit",
        data: { "nombre": value, "id": id },
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "El equipo ya está registrado en el sistema");



var validator = $("#equipoUpdateForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    //onfocusout: false,
    rules: {
        equipo: {
            required: true,
           nombreUnico: true
        }

    },
    messages: {
        equipo: {
            required: "Por favor, ingrese el equipo"
        }
    }
});


//Mostrar y ocultar formulario
if (window.location.hash === '#edit') {
    $('#equipoUpdateModal').modal('show');
}

$('#equipoUpdateModal').on('hide.bs.modal', function () {
    $("#equipoUpdateForm").validate().resetForm();
    document.getElementById("equipoUpdateForm").reset();
    window.location.hash = '#';
    $('#ubicaciones').empty();
    $('#nombre').empty();
    $('#locations').empty();
    $('#equipo').empty();
    $('#id').empty();
    $('#equipo').empty();
});

$('#equipoUpdateModal').on('shown.bs.modal', function () {
    window.location.hash = '#edit';

}); 

//Mostrar modal 
$('#equipoUpdateModal').on('shown.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var nombre = button.data('nombre');
    var desc = button.data('desc');
    var ubicacionId = button.data('idubi');
    var ubicacionN = button.data('ubi');
    $('#id').val(id);
    $('#equipo').val(nombre);
    $.getJSON('/ubicaciones/' + ubicacionId , function (data) {
        $('#locations').append('<option selected="selected" value="' + ubicacionId + '">' + ubicacionN + '</option>');
        $.each(data.ubicaciones, function () {
          
            $('#locations').append('<option value="' + this.id + '">' + this.ubicacion + '</option>');
        });
    });

    var modal = $(this);
    modal.find(".modal-body input[name='id']").val(id);

    modal.find(".modal-body input[name='equipo']").val(nombre);
    modal.find(".modal-body input[name='descripcion']").val(desc);

});