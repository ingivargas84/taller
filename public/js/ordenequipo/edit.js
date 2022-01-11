
var validator = $("#OrdenTrabajoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		no_comprobante:{
			required: true
		},
		equipo_id: {
			required : true
		},
		cliente_id: {
			required : true
		}

	},
	messages: {
		no_comprobante: {
			required: "Por favor, ingrese un número de comprobante"
		},
		equipo_id: {
			required: "Por favor, Seleccione un equipo"
		},
		cliente_id: {
			required: "Por favor, Seleccione un cliente"
		}

	}
});


$("#ButtonOrdenUpdate").click(function(event) {
	if ($('#OrdenTrabajoUpdateForm').valid()) {
		$('.loader').addClass("is-active");

	} else {
		validator.focusInvalid();
	}
});