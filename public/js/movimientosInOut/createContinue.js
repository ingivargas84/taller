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
var validator = $("#modalOpenContinueForm").validate({
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
        desc: {
            required: true,
        },
        receptor: {
            required: true,
        }
    },
    messages: {
        monto: {
            required: "Por favor, ingrese el monto",
            number: "Ingrese únicamente números",
            onlyInteger: "Subir unicamente números positivos",
        },
        desc: {
            required: "Por favor, ingrese el campo",
        },
        receptor: {
            required: "Por favor, llene el campo",
        }
    }
});
//Acción Guardar 
$("#ButtonOpenContinueModal").click(function (event) {
    event.preventDefault();
    if ($('#modalOpenContinueForm').valid()) {
        if ($('#idCaja').val() != null ) {
            if ($('#idCaja').val() === "") {
                saveModal();
                
            } else {
                saveCashFlow();
        }
        } else {
            saveModal();    
        }
    } else {
        validator.focusInvalid();
    }
});

//Guardar segundo movimiento 
function saveCashFlow(button) {
    var formData = $("#modalOpenContinueForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#tokenOpenContinue').val() },
        url: urlActual + "/save",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('#modalContinue').modal('hide');
            location.replace(urlActual);
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#modalOpenContinueForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}

//
//Guardar un nuevo registro
function saveModal(button) {
    var formData = $("#modalOpenContinueForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#tokenOpenContinue').val() },
        url: urlActual + "/open",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('#modalContinue').modal('hide');
            location.replace(urlActual);
            

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#modalOpenContinueForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}
//Mostrar y ocultar formulario
if (window.location.hash === '#create') {
    $('#modalContinue').modal('show');
}

$('#modalContinue').on('hide.bs.modal', function () {
    $('#salidaForm').html('');
    $("#modalOpenContinueForm").validate().resetForm();
    document.getElementById("modalOpenContinueForm").reset();
    window.location.hash = '#';
    
});

$('#modalContinue').on('shown.bs.modal', function () {
    window.location.hash = '#create';
}); 