$.validator.addMethod('entero', function(value, element){
    var regex = new RegExp("^(0+[1-9]|[1-9])[0-9]*$");
    return regex.test(value);
},"Esta cantidad no puede ser menor o igual a 0");
$.validator.addMethod('dinero', function(value, element){
    var regex = new RegExp("^\\d+(?:\\.\\d{0,2})?$");
    return regex.test(value);
},"El producto no puede costar menos de Q 0.00");
var validator = $("#TallerDiagnosticoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		cantidad:{
			  entero: true,
		},
		cantidadP:{
			  entero: true,
		},
		cantidadE:{
			  entero: true,
		},
    precioE:{
        dinero: true,
    },

		detalle_diagnostico:{
			required: true
		}
	},
	messages: {
		detalle_diagnostico: {
			required: "Por favor, ingrese el detalle del diagnóstico"
		}
	}
});

$("#ButtonTallerDiagnostico").click(function(event) {
	if ($('#TallerDiagnosticoForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});
