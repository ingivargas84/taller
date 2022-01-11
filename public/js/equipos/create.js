//Nombre unico
$.validator.addMethod("nombreUnico", function (value, element) {
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "POST",
        async: false,
        url: urlActual + "/nombreDisponible",
        data: "nombre=" + value,
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "El nombre del equipo ya está registrado en el sistema");


//validate
var validator = $("#equipoForm").validate({
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
            required: "Por favor, ingrese el nombre del nuevo equipo"
        }
    }
});


//Logica para mostrar las ubicaciones
$('#equipoModal').click().on('shown.bs.modal', function (event) {
    console.log('dada');
    $.getJSON('/ubicaciones', function(data) {
        $.each(data, function() {
            $('#ubicaciones').append('<option value="' + this.id + '">' + this.ubicacion + '</option>');          
        });
    });
});




//Acción Guardar 
$("#ButtonEquipoModal").click(function (event) {
    event.preventDefault();
    if ($('#equipoForm').valid()) {
        saveModal();
    } else {
        validator.focusInvalid();
    }
});


//Guardar un nuevo registro
function saveModal(button) {
    var formData = $("#equipoForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#equipoForm').val() },
        url: urlActual + "/save",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#equipoModal').modal('hide');
            equipoTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('El equipo fue creado con Éxito!!');

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#equipoForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}



//Mostrar y ocultar formulario
if (window.location.hash === '#create') {
    $('#equipoModal').modal('show');
}

$('#equipoModal').on('hide.bs.modal', function () {
    $("#equipoForm").validate().resetForm();
    document.getElementById("equipoForm").reset();
    window.location.hash = '#';
    $('#ubicaciones').empty();
    $('#nombre').empty();

});

$('#equipoModal').on('shown.bs.modal', function () {
    window.location.hash = '#create';

}); 