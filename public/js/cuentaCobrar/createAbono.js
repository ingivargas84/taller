//
$('#fecha').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy'
});

$.validator.addMethod("greater", function (value, element) {
    if (value <= 0) {
        return false;
    } else {
        return true;
    }
});

//Fecha actual
function getFecha() {
    let date = new Date()

    let day = date.getDate()
    let month = date.getMonth() + 1
    let year = date.getFullYear()

    if (month < 10) {
        return `${day}-0${month}-${year}`;
    } else {
        return `${day}-${month}-${year}`;
    }
}
$("input[name='fecha']").val(getFecha());

$.validator.addMethod("checkQuantity", function (value, element) {
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: urlActual + "/check",
        data: "abono=" + value,
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        },
    });
    return valid;
});

//validate
var validator = $("#abonoForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    //onfocusout: false,
    rules: {
        abono: {
            required: true,
            number: true,
            greater: true,
            checkQuantity: true,
        },
        fecha: {
            required: true,
        },
    },
    messages: {
        abono: {
            required: "Por favor, ingrese el saldo a abonar",
            number: "Por favor, ingrese numeros",
            greater: "Ingresa un número mayor a 0",
            checkQuantity: "El abono debe ser menor o igual al saldo actual",
        },
        fecha: {
            required: "Por favor, ingrese la fecha",
        },
    },
});

//Acción Guardar
$("#ButtonAbonoModal").click(function (event) {
    event.preventDefault();
    if ($("#abonoForm").valid()) {
        saveModal();
    } else {
        validator.focusInvalid();
    }
});

//Guardar un nuevo registro
function saveModal(button) {
    var formData = $("#abonoForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $(".loader").fadeIn();
    $.ajax({
        type: "POST",
        headers: { "X-CSRF-TOKEN": $("#abonoForm").val() },
        url: "/cuentasPorCobrar/" + $("#id").val() + "/Abono/save",
        data: formData,
        dataType: "json",
        success: function (data) {
            $(".loader").fadeOut(225);
            $("#abonoModal").modal("hide");
            cuentaDetalleTable.ajax.reload();
            alertify.set("notifier", "position", "top-center");
            alertify.success("La cuenta fue abonada con éxito!!");
        },
        error: function (errors) {
            $(".loader").fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#abonoForm input[name='nombre'] ").after(
                    "<label class='error' id='ErrorNombre'>" +
                        errors.nombre +
                        "</label>"
                );
            } else {
                $("#ErrorNombre").remove();
            }
        },
    });
}

//Mostrar y ocultar formulario
if (window.location.hash === "#create") {
    $("#abonoModal").modal("show");
    $("input[name='fecha']").val(new Date().toDateInputValue());
}

$("#abonoModal").on("hidden.bs.modal", function () {
    $("#abonoForm").validate().resetForm();
    document.getElementById("abonoForm").reset();
    window.location.hash = "#";
    $("#abono").empty();
});

$("#abonoModal").on("shown.bs.modal", function () {
    window.location.hash = "#create";
    $("input[name='fecha']").val(getFecha());
});
