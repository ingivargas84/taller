
var validator = $("#RequiInsumosForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		justificacion: {
			required : true
		}
	},
	messages: {
		justificacion: {
			required: "Por favor, ingrese una justificación"
		}
	}
});