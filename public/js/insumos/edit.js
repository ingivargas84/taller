
var validator = $("#ClienteUpdateForm").validate({
		ignore: [],
		onkeyup:false,
		rules: {
			nombre_insumo:{
				required: true
			}
		},
		messages: {
			nombre_insumo: {
				required: "Por favor, ingrese el nombre"
			}
		}
	});



$("#ButtonInsumoUpdate").click(function(event) {
	if ($('#InsumoUpdateForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});