$.validator.addMethod("onlyInteger", function (value) {
    var regX = /^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/;
    if (regX.test(value.trim()) == false) {
        $(this).val('');
        return false;
    } else {
        return true;
    }
});

//validate
var validator = $("#modalOpenForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    //onfocusout: false,
    rules: {
        monto: {
            required: true,
            number: true,
            onlyInteger: true,
        },
    },
    messages: {
        monto: {
            required: "Por favor, ingrese el monto",
            number: "Ingrese únicamente números",
            onlyInteger: "Subir unicamente números positivos",
        },
    }
});
//Acción Guardar 
$("#ButtonOpenCashModal").click(function (event) {
    event.preventDefault();
    if ($('#modalOpenForm').valid()) {
        openCash();
    } else {
        validator.focusInvalid();
    }
});

//Guardar un nuevo registro
function openCash(button) {
    var formData = $("#modalOpenForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#tokenOpenCash').val() },
        url: urlActual + "/open",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('#modalOpen').modal('hide');
            location.replace(urlActual);
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#modalOpenForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}
//Mostrar y ocultar formulario
if (window.location.hash === '#create') {
    $('#modalOpen').modal('show');
}

$('#modalOpen').on('hide.bs.modal', function () {
    $("#modalOpenForm").validate().resetForm();
    document.getElementById("modalOpenForm").reset();
    window.location.hash = '#';

});

$('#modalOpen').on('shown.bs.modal', function () {
    window.location.hash = '#create';
}); 