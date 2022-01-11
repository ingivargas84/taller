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
function validatePerEdit() {
    //
    $("#porcentajeEdit").rules("add", {
        required: true,
        onlyPositive: true,
        number: true,
        messages: {
            required: "Por favor, escribir la cantidad",
            onlyPositive: "Por favor, solo números positivos",
            number: "Por favor, solo datos numéricos",
        }
    });

    $('#multipEdit, #cantidadEdit').each(function () { $(this).rules('remove'); });
    $('#seccionPorcentajeEdit').show();
    $('#seccionCalculadoEdit').hide();
    $('#seccionFijoEdit').hide();
    //
}

//Validar Calculado
function validateCalcEdit() {

    $("#multipEdit").rules("add", {
        required: true,
        onlyPositive: true,
        number: true,
        messages: {
            required: "Por favor, escribir la cantidad a multiplicar",
            onlyPositive: "Por favor, solo números positivos",
            number: "Por favor, solo datos numéricos",
        }
    });
    $('#porcentajeEdit, #cantidadEdit').each(function () { $(this).rules('remove'); });
    $('#seccionCalculadoEdit').show();
    $('#seccionPorcentajeEdit').hide();
    $('#seccionFijoEdit').hide();

}

//Validar fijo
function validateFijoEdit() {

    if ($('#valor_afecto_f_edit').val() == '1') {
        $('#seccionAutoEdit').hide();
        $('#porcentajeEdit, #multipEdit, #cantidadEdit').each(function () { $(this).rules('remove'); });

    } else if ($('#valor_afecto_f_edit').val() == '2') {
        $("#cantidadEdit").rules("add", {
            required: true,
            onlyPositive: true,
            number: true,
            messages: {
                required: "Por favor, escribir la cantidad",
                onlyPositive: "Por favor, solo números positivos",
                number: "Por favor, solo datos numéricos",
            }

        });
        $('#seccionAutoEdit').show();
        $('#porcentajeEdit, #multipEdit').each(function () { $(this).rules('remove'); });
    }
    $('#seccionFijoEdit').show();
    $('#seccionCalculadoEdit').hide();
    $('#seccionPorcentajeEdit').hide();
    $('#valor_afecto_f_edit').change(function () {

    });
}
//
$('#modalInEgresoEdit').click().on('shown.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var nombre = button.data('nombre');
    var tipoCalc = button.data('tipoc');
    var tipoMov = button.data('tipom');
    //Porcentaje y Calculado
    var valorPC = button.data('valorpc');
    var valorPorcentaje = button.data('porcen');
    //Multiplicacion para Calculo
    var valorMult = button.data('multiplicar');
    var valorAM = button.data('valoram');
    //Fijo
    var cant = button.data('cant');
    
    //Agregar datos
    $('#id').val(id);
    $('#nombreEdit').val(nombre);
    $("#tipoCe").val(tipoCalc).change();
    $("#tipoMe").val(tipoMov).change();
    //
    if (tipoCalc == 1) {
        $("#porcentajeEdit").val(parseFloat(valorPorcentaje * 100).toFixed(2)).change();
        $("#valor_afecto_p_edit").val(valorPC).change();
        validatePerEdit();
        
    } else if (tipoCalc == 2) {
        $("#valor_afecto_c_edit").val(valorPC).change();
        $("#multipEdit").val(valorMult).change();
        validateCalcEdit();
        
    } else {
        $("#valor_afecto_f_edit").val(valorAM).change();
        validateFijoEdit();
        if ($('#valor_afecto_f_edit').val() == 1) {

            $('#porcentajeEdit, #multipEdit, #cantidadEdit').each(function () { $(this).rules('remove'); });
            $('#seccionAutoEdit').hide();

        } else if ($('#valor_afecto_f_edit').val() == 2) {
            $('#cantidadEdit').val(cant);
            $('#seccionAutoEdit').show();
            $('#porcentajeEdit, #multipEdit').each(function () { $(this).rules('remove'); });
            $('#seccionAutoEdit').show();
            $("#cantidadEdit").rules("add", {
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



    $('#tipoCe').change(function () {
        if ($('#tipoCe').val() == 1) {
            validatePerEdit();
            $('#isWhatEdit').val(1);
        } else if ($('#tipoCe').val() == 2) {
            validateCalcEdit();
            $('#isWhatEdit').val(2);
        } else {
            $('#valor_afecto_f_edit').change(function () {
                if ($('#valor_afecto_f_edit').val() == '1') {
                    $('#seccionAutoEdit').hide();
                    $('#porcentajeEdit, #multipEdit, #cantidadEdit').each(function () { $(this).rules('remove'); });

                } else if ($('#valor_afecto_f_edit').val() == '2') {
                    $("#cantidadEdit").rules("add", {
                        required: true,
                        messages: {
                            required: "Por favor, escribir la cantidad",
                        }
                    });
                    $('#seccionAutoEdit').show();
                    $('#porcentajeEdit, #multipEdit').each(function () { $(this).rules('remove'); });
                }
            });
            validateFijoEdit();
            $('#isWhatEdit').val(3);
        }
    });
});




//Acción Guardar 
$("#ButtonInEgresoUpdateModal").click(function (event) {
    event.preventDefault();
    if ($('#InEgresoEditForm').valid()) {
        updateModal();
    } else {
        validator.focusInvalid();
    }
});


//Guardar un nuevo registro
function updateModal(button) {
    var formData = $("#InEgresoEditForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "PUT",
        headers: { 'X-CSRF-TOKEN': $('#InEgresoEditForm').val() },
        url: urlActual + "/update",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#modalInEgresoEdit').modal('hide');
            movsTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('El movimiento fue editado con Éxito!!');

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#InEgresoEditForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}



//Mostrar y ocultar formulario
if (window.location.hash === '#create') {
    $('#modalInEgresoEdit').modal('show');


}

$('#modalInEgresoEdit').on('hide.bs.modal', function () {
    $("#InEgresoEditForm").validate().resetForm();
    document.getElementById("InEgresoEditForm").reset();
    window.location.hash = '#';
    $('#cantidadEdit').empty();
    $('#multiEdit').empty();
    $('#porcentajeEdit').empty();
    $('#nombreEdit').empty();

});


var validator = $("#InEgresoEditForm").validate();
$('#nombreEdit').rules('add', {
    required: true,
    messages: {
        required: 'Por favor, llene el campo'
    }
});
$(document).ready(function () {

    $("#porcentajeEdit").rules("add", {
        required: true,
        onlyPositive: true,
        number: true,
        messages: {
            required: "Por favor, escribir la cantidad",
            onlyPositive: "Por favor, solo números positivos",
            number: "Por favor, solo datos numéricos",
        }
    });

    if ($('#tipoCe').val() == 1) {
        $('#seccionPorcentajeEdit').show();
        $('#seccionCalculadoEdit').hide();
        $('#seccionFijoEdit').hide();
        $('#isWhatEdit').val(1);

    } else if ($('#tipoC').val() == 2) {
        $('#seccionCalculadoEdit').show();
        $('#seccionPorcentajeEdit').hide();
        $('#seccionFijoEdit').hide();
        $('#isWhatEdit').val(2);
    } else {
        $('#seccionFijoEdit').show();
        $('#seccionCalculadoEdit').hide();
        $('#seccionPorcentajeEdit').hide();
        $('#isWhatEdit').val(3);

    }

    if ($('#valor_afecto_f_edit').val() == 1) {

        $('#seccionAutoEdit').hide();

    } else if ($('#valor_afecto_f_edit').val() == 2) {

        $('#seccionAutoEdit').show();

    }
});