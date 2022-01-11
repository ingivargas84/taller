
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



$.validator.addMethod("nit", function (value, element) {
    var valor = value;

    if (nitIsValid(valor) == true) {
        return true;
    }

    else {
        return false;
    }
}, "El NIT ingresado es incorrecto o inválido, reviselo y vuelva a ingresarlo");


$.validator.addMethod("ntel", function (value, element) {
    var valor = value.length;
    if (valor == 8) {
        return true;
    }
    else {
        return false;
    }
}, "Debe ingresar el número de teléfono con 8 dígitos, en formato ########");


var validator = $('#VendedorUpdateForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        nombres: {
            required: true,
        },
        apellidos: {
            required: true,
        },
        nit: {
            nit: true,
        },
        direccion: {
            required: true,
        },
        celular: {
            required: true,
            ntel: true,
        },
        comision: {
            required: true,
            number: true,
        },
        correo: {
            email: true,
            required: true,
        },
    },
    messages: {
        correo: {
            email: "Utilice un formato de correo válido",
            required: "Por favor, ingrese un correo",
        },
        nombres: {
            required: "Por favor, ingrese el nombre del vendedor",
        },
        apellidos: {
            required: "Por favor, ingrese el apellido del vendedor",
        },
        direccion: {
            required: "Por favor, ingrese la direccion del vendedor",
        },
        celular: {
            required: "Por favor, ingrese el celular del vendedor",
        },
        comision: {
            required: "Por favor, ingrese la comisión para el vendedor",
            number: "Ingrese unicamente números",
        },
    }
});
$("#ButtonVendedorUpdate").click(function (event) {
    if ($('#VendedorUpdateForm').valid()) {
        $('.loader').addClass("is-active");
    } else {
        validator.focusInvalid();
    }
});
