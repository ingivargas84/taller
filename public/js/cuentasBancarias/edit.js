//Actualizar
function updateModal(button) {
    var formData = $("#cuentaUpdateForm").serialize();
    var id = $("input[name='id']").val();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "PUT",
        headers: { 'X-CSRF-TOKEN': $('#cuentaUpdateToken').val() },
        url: urlActual + "/" + id + "/update",
        data: formData,
        dataType: "text",
        success: function (data) {
            $('.loader').fadeOut(225);
            BorrarFormularioUpdate();
            $('#cuentaUpdateModal').modal("hide");
            cuentaTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('La cuenta ha sido editada con Éxito!!');
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.email != null) {
                $("#cuentaUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>" + errors.email + "</label>");
            }
            else {
                $("#ErrorNombreedit").remove();
            }
        }

    });
}



$("#ButtonCuentaModalUpdate").click(function (event) {
    event.preventDefault();
    if ($('#cuentaUpdateForm').valid()) {
        updateModal();
    } else {
        validator.focusInvalid();
    }
});

//Eliminar data de form
function BorrarFormularioUpdate() {
    $("#cuentaUpdateForm :input").each(function () {
        $(this).val('');
    });
};
//
// $.validator.addMethod("onlyInteger", function (value) {
//     var regX = /^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/;
//     if (regX.test(value.trim()) == false) {
//         $(this).val('');
//         return false;
//     } else {
//         return true;
//     }
// });
//validate
var validator = $("#cuentaUpdateForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    //onfocusout: false,
    rules: {
        nombre_edit: {
            required: true,
        },
        no_cuenta_edit: {
            required: true,
            number: true,
        },
        banco: {
            required: true,
        },
        tipo_cuenta: {
            required: true,
        }

    },
    messages: {
        nombre_edit: {
            required: "Por favor, ingrese el nombre de la cuenta"
        },
        no_cuenta_edit: {
            required: "Por favor, ingrese el no. de cuenta",
            number: "Ingrese unicamente números",
        },
        banco: {
            required: "Por favor, llene el campo",
        },
        tipo_cuenta: {
            required: "Por favor, seleccione el tipo de cuenta",
        }
    }
});


//Mostrar y ocultar formulario
if (window.location.hash === '#edit') {
    $('#equipoUpdateModal').modal('show');
}

$('#cuentaUpdateModal').on('hide.bs.modal', function () {
    $("#cuentaUpdateForm").validate().resetForm();
    document.getElementById("cuentaUpdateForm").reset();
    window.location.hash = '#';
    $('#tipo_cuenta_edit').empty();
    $('#nombre_edit').empty();
    $('#banco_id_edit').empty();
    $('#id').empty();
});

$('#cuentaUpdateModal').on('shown.bs.modal', function () {
    window.location.hash = '#edit';

});

//Mostrar modal 
$('#cuentaUpdateModal').on('shown.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var nombre_edit = button.data('nombre_edit');
    var no_edit = button.data('no_edit');
    var tipo_cuenta = button.data('tipo_cuenta');
    var tipo_cuenta_id = button.data('tipo_cuenta_id');
    var banco_id = button.data('banco_id');
    var banco_nombre = button.data('banco_nombre');
    $('#id').val(id);
    $('#nombre_edit').val(nombre_edit);
    $('#no_cuenta_edit').val(no_edit);
    //
    $.getJSON('/tipos/' + tipo_cuenta_id, function (data) {
        $('#tipo_cuenta_edit').append('<option selected value="' + tipo_cuenta_id + '">' + tipo_cuenta + '</option>');
        $.each(data, function () {
            $('#tipo_cuenta_edit').append('<option value="' + this.id + '">' + this.tipo + '</option>');
        });
    });

    $.getJSON('/bancos/' + banco_id, function(data) {
        $('#banco_id_edit').append('<option selected value="' + banco_id + '">' + banco_nombre + '</option>');
        $.each(data, function () {
            $('#banco_id_edit').append('<option value="' + this.id + '">' + this.banco + '</option>');
        });
    });
    //

    var modal = $(this);
    modal.find(".modal-body input[name='id']").val(id);

    modal.find(".modal-body input[name='nombre_edit']").val(nombre_edit);
    //modal.find(".modal-body input[name='tipo_cuenta']").val(tipo_cuenta);

});