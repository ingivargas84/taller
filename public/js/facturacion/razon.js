//validate
var validator = $("#razonForm").validate({
    ignore: [],
    onkeyup: false,
    onclick: false,
    //onfocusout: false,
    rules: {
        razon: {
            required: true,
        }

    },
    messages: {
        razon: {
            required: "Por favor, ingrese la razón",
        },
    }
});



//Acción Guardar 
$("#ButtonRazonModal").click(function (event) {
    event.preventDefault();
    if ($('#razonForm').valid()) {
        deleteModal();
    } else {
        validator.focusInvalid();
    }
});


//Guardar un nuevo registro
function deleteModal(button) {
    var formData = $("#razonForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "DELETE",
        headers: { 'X-CSRF-TOKEN': $('#razonForm').val() },
        url: urlActual + "/anular/" + $("#idFactura").val(),
        data: formData,
        dataType: "json",
        success: function (data) {
            window.location.href = urlActual;
            //alertify.set('notifier', 'position', 'top-center');
            //alertify.success('La factura fue anulada correctamente!!');

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#razonForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}



//Mostrar y ocultar formulario
if (window.location.hash === '#razon') {
    $('#razonModal').modal('show');
}

$('#razonModal').on('hide.bs.modal', function () {
    $("#razonForm").validate().resetForm();
    document.getElementById("razonForm").reset();
    window.location.hash = '#';
    $('#idFactura').val("");
});

$('#razonModal').on('shown.bs.modal', function () {
    window.location.hash = '#razon';
  
});



function getFactura(id) {
    $('#idFactura').val(id);
}
