
var validator = $("#VisitaEditForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        cliente_id: {
            required: true,
        },
        observaciones: {
            required: true
        }
    },
    messages: {
        cliente_id: {
            required: 'Por favor, seleccione un cliente',
        },
        observaciones: {
            required: 'Por favor, ingrese las observaciones pertinentes'
        }
    }
});

$("#ButtonVisitasUpdate").click(function (event) {
    if ($('#VisitaEditForm').valid()) {
        $('.loader').addClass("is-active");
    } else {
        validator.focusInvalid();
    }
});