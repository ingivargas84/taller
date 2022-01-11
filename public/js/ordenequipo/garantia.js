//validate
$(document).ready(function() {

    var validator = $("#garantiaForm").validate({
        ignore: [],
        onkeyup: false,
        onclick: false,
        //onfocusout: false,
        rules: {
            fecha: {
                required: true,
            },
        },
        messages: {
            fecha: {
                required: "Por favor, ingrese la fecha",
            },
        },
    });
//
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
    //
    $('#fecha').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    //

    //Acción Guardar
    $("#ButtonGarantiaModal").click(function (event) {
        event.preventDefault();
        if ($("#garantiaForm").valid()) {
            saveModal();
        } else {
            validator.focusInvalid();
        }
    });


    //Guardar un nuevo registro
    function saveModal(button) {
        var formData = $("#garantiaForm").serialize();
        var urlActual = $("input[name='urlActual']").val();
        $(".loader").fadeIn();
        console.log($('#fecha').val());
        console.log($("#ordenID").val());
        // JSON (Content-Type →application/json; charset=utf-8).
        $.ajax({
            type: "POST",
            headers: { "X-CSRF-TOKEN": $("#garantiaForm").val() },
            url: "/ordenequipo/" + $("#ordenID").val() + "/garantia/save",
            data: {
                'fecha': $('#fecha').val(),
                'ordenid': $("#ordenID").val()
            },
            //dataType: "json",
            success: function (data) {
                $(".loader").fadeOut(225);
                $("#garantiaModal").modal("hide");
                ordenEquipo.ajax.reload();
                alertify.set("notifier", "position", "top-center");
                alertify.success("Se ha creado la garantía, ahora puedes ya descargar el PDF!!");
            },
            error: function (errors) {
                $(".loader").fadeOut(225);
                var errors = JSON.parse(errors.responseText);
                if (errors.nombre != null) {
                    $("#garantiaForm input[name='nombre'] ").after(
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

//
    //Mostrar y ocultar formulario
    if (window.location.hash === "#garantia") {
        $("#garantiaModal").modal("show");
        $("input[name='fecha']").val(getFecha());
    }

    $("#garantiaModal").on("hidden.bs.modal", function () {
        $("#garantiaForm").validate().resetForm();
        document.getElementById("garantiaForm").reset();
        window.location.hash = "#";
        $("#garantiaID").empty();
    });

    $("#garantiaModal").on("shown.bs.modal", function () {
        window.location.hash = "#garantia";
        $("input[name='fecha']").val(getFecha());

    });


});
function takeID(id) {
    $("#ordenID").val(id);
}