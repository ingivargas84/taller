$.validator.addMethod('entero', function(value, element){
  var a =value;

  if(a !== null){
    var regex = new RegExp("^(0+[1-9]|[1-9])[0-9]*$");
    return regex.test(value);
  }
},"Esta cantidad no puede ser menor o igual a 0");
$.validator.addMethod('dinero', function(value, element){
    var regex = new RegExp("^\\d+(?:\\.\\d{0,2})?$");
    return regex.test(value);
},"La cantidad no puede ser  menos de Q 0.00");

var validator = $("#PagoTelForm").validate({


	ignore: [],
	onkeyup:false,
	rules: {
		cantidad:{

		},
    documento:{

	}
},
	messages: {
	

	}
});

$("#agregar-detalle").click(function(event) {
	if ($('#PagoTelForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});
