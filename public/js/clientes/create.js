$('#datepickerNC').datepicker({
	autoclose: true,
	format: 'yyyy-mm-dd'
  });


//Funcion para validar NIT
function nitIsValid(nit) {
	if (!nit) {
		return true;
	}

	var nitRegExp = new RegExp('^[0-9]+(-?[0-9kK])?$');

	if (!nitRegExp.test(nit)) {
		return false;
	}

	nit = nit.replace(/-/, '');
	var lastChar = nit.length - 1;
	var number = nit.substring(0, lastChar);
	var expectedCheker = nit.substring(lastChar, lastChar + 1).toLowerCase();

	var factor = number.length + 1;
	var total = 0;

	for (var i = 0; i < number.length; i++) {
		var character = number.substring(i, i + 1);
		var digit = parseInt(character, 10);

		total += (digit * factor);
		factor = factor - 1;
	}

	var modulus = (11 - (total % 11)) % 11;
	var computedChecker = (modulus == 10 ? "k" : modulus.toString());

	return expectedCheker === computedChecker;
}

$.validator.addMethod("nit", function(value, element){
var valor = value;

if(nitIsValid(valor)==true)
{
	return true;
}

else
{
	return false;
}
}, "El NIT ingresado es incorrecto o inválido, reviselo y vuelva a ingresarlo");


$.validator.addMethod("ntel", function(value, element) {
	var valor = value.length;
	if (valor == 8)
	{
		return true;
	}
	else
	{
		return false;
	}
}, "Debe ingresar el número de teléfono con 8 dígitos, en formato ########");


$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $("#ClienteForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nit:{
			required: true
		},
		nombre: {
			required : true
		},
		contacto: {
			required : true
		},
		telefono: {
			ntel:true,
			required : true
		},
		direccion: {
			required : true
		},
		empleado_id: {
			required : true,
			select: 'default'
		},
		tipocliente_id: {
			required : true,
			select: 'default'
		},
		nombre_comercial: {
			required : true
		},
		correo_electronico:{
			required : true,
			email: true
		}

	},
	messages: {
		nit: {
			required: "Por favor, ingrese el nit"
		},
		nombre: {
			required: "Por favor, ingrese el nombre del cliente"
		},
		contacto: {
			required: "Por favor, ingrese el contacto del cliente"
		},
		telefono: {
			required: "Por favor, ingrese el número de telefono"
		},
		direccion: {
			required: "Por favor, ingrese la dirección del cliente"
		},
		empleado_id: {
			required: "Por favor, seleccione una opción"
		},
		nombre_comercial: {
			required: "Por favor, seleccione una opción"
		},
		tipocliente_id: {
			required: "Por favor, seleccione una opción"
		},
		correo_electronico: {
			email: "El formato de correo no es correcto"
		}

	}
});

$("#ButtonCliente").click(function(event) {
	if ($('#ClienteForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});