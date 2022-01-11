//
$.validator.addMethod("onlyPositive", function (value) {
    var regX = /^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/;
    if (regX.test(value.trim()) == false) {
        $(this).val('');
        return false;
    } else {
        return true;
    }
});
//
//Validar solo porcentaje
function validatePer() {
    //
    $("#porcentaje").rules("add", {
        required: true,
        onlyPositive: true,
        number: true,
        messages: {
            required: "Por favor, escribir la cantidad",
            onlyPositive: "Por favor, solo números positivos",
            number: "Por favor, solo datos numéricos",
        }
    });
    
    $('#multip, #cantidad').each(function () { $(this).rules('remove'); });
    $('#seccionPorcentaje').show();
    $('#seccionCalculado').hide();
    $('#seccionFijo').hide();
    //
}

//Validar Calculado
function validateCalc() {

    $("#multip").rules("add", {
        required: true,
        onlyPositive: true,
        number: true,
        messages: {
            required: "Por favor, escribir la cantidad a multiplicar",
            onlyPositive: "Por favor, solo números positivos",
            number: "Por favor, solo datos numéricos",
        }
    });
    $('#porcentaje, #cantidad').each(function () { $(this).rules('remove'); });
    $('#seccionCalculado').show();
    $('#seccionPorcentaje').hide();
    $('#seccionFijo').hide();

}

//Validar fijo
function validateFijo() {

    if ($('#valor_afecto_f').val() == '1') {
        $('#seccionAuto').hide();
        $('#porcentaje, #multip, #cantidad').each(function () { $(this).rules('remove'); });

    } else if ($('#valor_afecto_f').val() == '2') {
        $("#cantidad").rules("add", {
            required: true,
            onlyPositive: true,
            number: true,
            messages: {
                required: "Por favor, escribir la cantidad",
                onlyPositive: "Por favor, solo números positivos",
                number: "Por favor, solo datos numéricos",
            }
            
        });
        $('#seccionAuto').show();
        $('#porcentaje, #multip').each(function () { $(this).rules('remove'); });
    }
    $('#seccionFijo').show();
    $('#seccionCalculado').hide();
    $('#seccionPorcentaje').hide();
    $('#valor_afecto_f').change(function () {

    });
}
//
$('#modalInEgreso').click().on('shown.bs.modal', function (event) {
    
    if ($('#tipoC').val() == 1) {
        validatePer();
        $('#isWhat').val(1);
    } else if ($('#tipoC').val() == 2) {
        validateCalc();
        $('#isWhat').val(2);
        
    } else {
        validateFijo();
        $('#isWhat').val(3);
        if ($('#valor_afecto_f').val() == 1) {

            $('#porcentaje, #multip, #cantidad').each(function () { $(this).rules('remove'); });
            $('#seccionAuto').hide();

        } else if ($('#valor_afecto_f').val() == 2) {

            $('#seccionAuto').show();
            $('#porcentaje, #multip').each(function () { $(this).rules('remove'); });
            $('#seccionAuto').show();
            $("#cantidad").rules("add", {
                required: true,
                onlyPositive: true,
                messages: {
                    number: true,
                    required: "Por favor, escribir la cantidad",
                    onlyPositive: "Por favor, solo números positivos",
                    number: "Por favor, solo datos numéricos",
                }

            });

        }
    }

    

    $('#tipoC').change(function() {
        if($('#tipoC').val() == 1) { 
            validatePer();
            $('#isWhat').val(1);
        } else if ($('#tipoC').val() == 2) {
            validateCalc();
            $('#isWhat').val(2);
        } else {
            $('#valor_afecto_f').change(function() {
                if ($('#valor_afecto_f').val() == '1') {
                    $('#seccionAuto').hide();
                    $('#porcentaje, #multip, #cantidad').each(function () { $(this).rules('remove'); });

                } else if ($('#valor_afecto_f').val() == '2') {
                    $("#cantidad").rules("add", {
                        required: true,
                        messages: {
                            required: "Por favor, escribir la cantidad",
                        }
                    });
                    $('#seccionAuto').show();
                    $('#porcentaje, #multip').each(function () { $(this).rules('remove'); });
                }
            });
            validateFijo();
            $('#isWhat').val(3);
        }
    });
});




//Acción Guardar 
$("#ButtonInEgresoModal").click(function (event) {
    event.preventDefault();
    if ($('#InEgresoForm').valid()) {
        saveModal();
    } else {
        validator.focusInvalid();
    }
});


//Guardar un nuevo registro
function saveModal(button) {
    var formData = $("#InEgresoForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#InEgresoForm').val() },
        url: urlActual + "/save",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#modalInEgreso').modal('hide');
            movsTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('El movimiento fue creado con Éxito!!');

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#InEgresoForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}



//Mostrar y ocultar formulario
if (window.location.hash === '#create') {
    $('#modalInEgreso').modal('show');

    
}

$('#modalInEgreso').on('hide.bs.modal', function () {
    $("#InEgresoForm").validate().resetForm();
    document.getElementById("InEgresoForm").reset();
    window.location.hash = '#';
    $('#cantidad').empty();
    $('#multi').empty();
    $('#porcentaje').empty();
    $('#nombre').empty();

});


var validator = $("#InEgresoForm").validate();
$('#nombre').rules('add', {
    required: true,
    messages: { 
        required: 'Por favor, llene el campo'
    }
});
$(document).ready(function() {

    $("#porcentaje").rules("add", {
        required: true,
        onlyPositive: true,
        number: true,
        messages: {
            required: "Por favor, escribir la cantidad",
            onlyPositive: "Por favor, solo números positivos",
            number: "Por favor, solo datos numéricos",
        }
    });

    if ($('#tipoC').val() == 1) {
        $('#seccionPorcentaje').show();
        $('#seccionCalculado').hide();
        $('#seccionFijo').hide();
        $('#isWhat').val(1);

    } else if ($('#tipoC').val() == 2) {
        $('#seccionCalculado').show();
        $('#seccionPorcentaje').hide();
        $('#seccionFijo').hide();
        $('#isWhat').val(2);
    } else {
        $('#seccionFijo').show();
        $('#seccionCalculado').hide();
        $('#seccionPorcentaje').hide();
        $('#isWhat').val(3);

    }

    if ($('#valor_afecto_f').val() == 1) {

        $('#seccionAuto').hide();

    } else if ($('#valor_afecto_f').val() == 2) {

        $('#seccionAuto').show();

    }
});