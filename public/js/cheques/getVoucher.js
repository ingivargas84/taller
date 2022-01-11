$.validator.addMethod("onlyPInteger", function (value) {
    var regX = /^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/;
    if (regX.test(value.trim()) == false) {
        $(this).val('');
        return false;
    } else {
        return true;
    }
});
var validator = $("#voucherForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        receptor_voucher: {
            required: true,
        },
    },
    messages: {
        receptor_voucher: {
            required: "Ingrese el receptor",
        },

    }
});

$("#ButtonVoucherModal").click(function (event) {
    if ($('#voucherForm').valid()) {
        $('.loader').addClass("is-active");
    } else {
        validator.focusInvalid();
    }
});

//
//Mostrar y ocultar formulario
if (window.location.hash === '#voucher') {
    $('#voucherModal').modal('show');
    
}

$('#voucherModal').on('hide.bs.modal', function () {
    $("#voucherForm").validate().resetForm();
    document.getElementById("voucherForm").reset();
    window.location.hash = '#';
    $('#receptor_voucher').empty();

});

$('#voucherModal').on('shown.bs.modal', function (event) {
    window.location.hash = '#voucher';
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var no_cheque = button.data('no_cheque');
    $('#cheque_id').val(id);
    $('#no').html("<b>No. Cheque:</b> "  + no_cheque);

}); 


//Acción Guardar 
$("#ButtonVoucherModal").click(function (event) {
    event.preventDefault();
    if ($('#voucherForm').valid()) {
        saveVoucher();
    } else {
        validator.focusInvalid();
    }
});

//Guardar un nuevo registro
function saveVoucher(button) {
    var formData = $("#voucherForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#voucherForm').val() },
        url: urlActual + "/vouchers/save",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#voucherModal').modal('hide');
            chequesTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('El voucher fue creado con Éxito, ya puedes generar PDF!!');

        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                $("#voucherForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>" + errors.nombre + "</label>");
            }
            else {
                $("#ErrorNombre").remove();
            }
        }

    });
}
