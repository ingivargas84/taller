$.validator.addMethod('entero', function(value, element){
    var regex = new RegExp("^(0+[1-9]|[1-9])[0-9]*$");
    return regex.test(value);
},"Esta cantidad no puede ser menor o igual a 0");


var validator = $("#DiagnosticoTallerForm").validate({
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
		dias_reparacion:{
            required: true,
        },
        trabajos_realizados:{
            required: true,
        }
	},
	messages: {
		trabajos_realizados: {
			required: "Por favor, ingrese los dias posibles para la reparación"
		},
		trabajos_realizados: {
			required: "Por favor, ingrese el detalle del diagnóstico"
		}
	}
});
