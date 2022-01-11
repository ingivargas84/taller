$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");

var validator = $("#VisitasForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		cliente_id:{
			required: true,
			select: 'default'
		},
		tipo_visita:{
			required: true,
			select: 'default'
		},
		observaciones:{
			required: true
		},
		nombre_cliente:{
			required: true
		}
	},
	messages: {
		cliente_id: {
			required: "Por favor, seleccione un cliente"
		},
		tipo_visita: {
			required: "Por favor, seleccione una razón"
		},
		observaciones: {
			required: "Por favor, ingrese las observaciones correspondientes"
		},
		nombre_cliente: {
			required: "Por favor, seleccione el cliente"
		}

	}
});

$("#ButtonVisita").click(function(event) {
	if ($('#VisitasForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});