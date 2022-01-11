
$.validator.addMethod("ComprobanteUnico", function (value, element) {
    var valid = false;
    var urlActual = $("input[name='no_comprobante']").val();
    $.ajax({
        type: "GET",
        async: false,
        url:  "/ordenequipo/ComprobanteDisponible/",
        data: "no_comprobante=" + value,
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "El No de Comprobante ya está registrado en el sistema");

$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $("#OrdenForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		no_comprobante: {
			required : true,
			ComprobanteUnico: true
		},
		cliente_id: {
			required : true,
			select: 'default'
		}
	},
	messages: {
		no_comprobante: {
			required: "Por favor, ingrese un número de comprobante"
		},
		cliente_id: {
			required: "Por favor, seleccione un cliente"
		}
	}
});

$("#ButtonOrden").click(function(event) {
	if ($('#OrdenForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});