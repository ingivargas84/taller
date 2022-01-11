$.validator.addMethod("nombreUnico", function (value, element) {
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: urlActual + "/nombreDisponible",
        data: "nombre=" + value,
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "El nombre del servicio ya está registrado en el sistema");



$.validator.addMethod("min", function (value) {
    if (value.trim() >= 0) {
        return true;
    } else {
        return false;
    }
});


var validator = $("#ServicioForm").validate({
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
            min: true,
            number: true,
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
function BorrarFormularioPuesto() {
    $("#ServicioForm :input").each(function () {
        $(this).val('');
    });
};

$("#ButtonServicioModal").click(function (event) {
    event.preventDefault();
    if ($('#ServicioForm').valid()) {
        saveModal();
    } else {
        validator.focusInvalid();
    }
});

function saveModal(button) {
    var formData = $("#ServicioForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    console.log(urlActual);
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#tokenServicio').val() },
        url: urlActual + "/save",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#modalServicio').modal("hide");
            servicios_table.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('Servicio Creado con Éxito!!');

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#ServicioForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}

if (window.location.hash === '#create') {
    $('#modalServicio').modal('show');
}

$('#modalServicio').on('hide.bs.modal', function () {
    $("#ServicioForm").validate().resetForm();
    document.getElementById("ServicioForm").reset();
    window.location.hash = '#';
    //BorrarFormularioPuesto();
});

$('#modalServicio').on('shown.bs.modal', function () {
    window.location.hash = '#create';

}); 