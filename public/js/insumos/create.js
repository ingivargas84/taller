$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $("#ClienteForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre_insumo:{
			required: true
		},
        tipo_insumo: {
            required: true,
            select: 'default'
        }
	},
	messages: {
		nombre_insumo: {
			required: "Por favor, ingrese el nombre"
		},
		tipo_insumo: {
			required: "Por favor, seleccione un insumo"
		}
	}
});



$("#ButtonInsumo").click(function(event) {
	if ($('#InsumoForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});