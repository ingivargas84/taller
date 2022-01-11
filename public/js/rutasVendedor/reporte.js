//Mostrar y ocultar formulario
if (window.location.hash === '#reporte') {
    $('#modalVisitas').modal('show');
    //

    //
}

$('#modalVisitas').on('hidden.bs.modal', function () {
    $("#modalVisitasForm").validate().resetForm();
    document.getElementById("modalVisitasForm").reset();
    window.location.hash = '#';

});

//
function getFecha(fecha) {
    let date = new Date(fecha)
    let day = date.getDate() + 1;
    let month = date.getMonth() + 1
    let year = date.getFullYear()

    if (month < 10) {
        return `${day}-0${month}-${year}`;
    } else {
        return `${day}-${month}-${year}`;
    }
}
//

$('#modalVisitas').on('shown.bs.modal', function () {
    window.location.hash = '#reporte';
    $.getJSON('/misRutas/fechas', function (data) {
        let inicial = data[0];
        let final = data[1];
         $("#tituloModal").html("Mi primera visita fue el: " + getFecha(inicial));
         $("#fechaInicial").val(getFecha(inicial));
        $("#fechaFinal").val(getFecha(final));

        function greater() {
            if ($("#fechaInicial").val() < getFecha(inicial)) {
                $("#fechaInicial").val(getFecha(inicial));
            }
        }

        function less() {
            if ($("#fechaFinal").val() > getFecha(final)) {
                $("#fechaFinal").val(getFecha(final));
            }
        }
        document.querySelector('#fechaInicial').onchange = greater;
        document.querySelector('#fechaFinal').onchange = less;
    });

});
//Datepickers
$('#fechaInicial').datepicker(
    {
        autoclose: true,
        format: 'dd-mm-yyyy',

    }).on('changeDate', function () {
        $(this).valid();
    });
//
$('#fechaFinal').datepicker(
    {
        autoclose: true,
        format: 'dd-mm-yyyy',

    }).on('onChange', function () {
        $(this).valid();
    });
//
//La fecha debe ser igual o menor a hoy
$.validator.addMethod("lessThenToday", function (value) {
    var givenDate = value;
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = dd + '-' + mm + '-' + yyyy;

    if (givenDate > today) {
        return false;
    } else {
        return true;
    }
});
//La fecha final debe ser mayor o igual a la inicial
$.validator.addMethod("greater", function (value) {
    let fechaInicial = $("#fechaInicial").val();
    let fechaFinal = $("#fechaFinal").val();
    if (fechaFinal >= fechaInicial) {
        return true;
    } else {
        return false;
    }
});



//validate
var validator = $("#modalVisitasForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    //onfocusout: false,
    rules: {
        fechaInicial: {
            required: true,
            lessThenToday: true,
        },
        fechaFinal: {
            required: true,
            lessThenToday: true,
            greater: true,
        }
    },
    messages: {
        fechaInicial: {
            required: "Por favor, seleccione una fecha",
            lessThenToday: "No puedes escribir fechas mayores a hoy",
        },
        fechaFinal: {
            required: "Por favor, seleccione una fecha",
            lessThenToday: "No puedes escribir fechas mayores a hoy",
            greater: "La fecha final debe ser igual o mayor a la inicial"

        }
    }
});


//Acción Guardar 
$("#ButtonReporteVisitaModal").click(function (event) {
    event.preventDefault();
    if ($('#modalVisitasForm').valid()) {
        $('#modalVisitasForm').submit();
    } else {
        validator.focusInvalid();
    }
});
