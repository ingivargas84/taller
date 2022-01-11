
//Cambio de url para eliminar
if (window.location.hash === '#delete') {
    $('#ubicacionEquipoDeleteModal').modal('show');
}

$('#ubicacionEquipoDeleteModal').on('hide.bs.modal', function () {
    $("#ubicacionEquipoDeleteForm")[0].reset();
    document.getElementById("ubicacionEquipoDeleteForm").reset();
    window.location.hash = '#';
    $("#mensaje").empty();
    $('#selectUbicaciones').empty();
    $('#selectEquipos').empty();
    $('#numeroEquipos').empty();
    $('#mensajeCambio').empty();
    $('#selectUbicaciones').attr('hidden', true);
    $('#selectEquipos').attr('hidden', true);
    $('#selectUbicaciones').removeClass('form-control form-control-lg');
    $('#selectEquipos').removeClass('form-control form-control-lg');
});


$('#ubicacionEquipoDeleteModal').on('shown.bs.modal', function () {
    window.location.hash = '#delete';
  //  $("#mensaje").empty();
  //  $('#selectUbicaciones').empty();
  //  $('#selectEquipos').empty();
  //  $('#numeroEquipos').empty();
  //  $('#mensajeCambio').empty();
  //  $('#selectUbicaciones').attr('hidden', true);
  //  $('#selectEquipos').attr('hidden', true);
  //  $('#selectUbicaciones').removeClass('form-control form-control-lg');
  //  $('#selectEquipos').removeClass('form-control form-control-lg');

}); 
//Mostrar modal 
$('#ubicacionEquipoDeleteModal').click().on('shown.bs.modal', function (event) {
    $('#ButtonUbicacionEquipoModalDelete').attr('disabled', 'disabled');
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var nombre = button.data('nombre');


    $.getJSON('/ubicaciones/' + id, function(data) {
        if (data.equiposUbi.length === 0) {
            $('#idUbicacion').val(id);
            $('#ButtonUbicacionEquipoModalDelete').removeAttr('disabled', 'disabled');
            $('.modal-h').height('20px');
            $('.row-h').height('20px');
            $('#mensaje').append('Seguro quieres desactivar la ubicación <b>' + data.ubicacion[0].ubicacion + '</b>');
        
        } else {
            $('#idUbicacion').val(id);
            $('.modal-h').height('140px');
            $('.row-h').height('140px');
            $('#selectUbicaciones').removeAttr('hidden');
            $('#selectUbicaciones').addClass('form-control form-control-lg');
            $('#selectEquipos').removeAttr('hidden');
            $('#selectEquipos').addClass('form-control form-control-lg');
            $('#mensajeCambio').append('Antes de desactivar, debes reubicar los equipos');
            //
            
            //
            $.getJSON('/equipos/' + id, function (dato) {
                $.each(dato, function () {
                    $('#selectEquipos').append('<option>' + this.equipo + '</option>');
                 
                });
                
                $('#numeroEquipos').append('Hay ' + dato.length + ' equipos actualmente en ' + data.ubicacion[0].ubicacion);
                //
                $('#selectUbicaciones').on('change', function () {
                    $('#nuevaU').val(this.value);
                   
                    var locat = $('#locat').val();
                    
                   
                    if(this.value != dato[0].id){
                        $('#ButtonUbicacionEquipoModalDelete').removeAttr('disabled', 'disabled');
                    } else {
                        $('#ButtonUbicacionEquipoModalDelete').attr('disabled', 'disabled');

                    }
                    if (locat === this.value) {

                        $('#ButtonUbicacionEquipoModalDelete').attr('disabled', 'disabled');
                    } else {
                        $('#ButtonUbicacionEquipoModalDelete').removeAttr('disabled', 'disabled');
                    }
                });
                //
            });
            //
            $('#selectUbicaciones').append('<option selected="selected" value="' + data.ubicacion[0].id + '">' + data.ubicacion[0].ubicacion +  '</option>'); 
            $.each(data.ubicaciones, function () {
                $('#selectUbicaciones').append('<option value="' + this.id + '">' + this.ubicacion +'</option>');
                                      
                    }); 
        }
    });
    var modal = $(this);
    modal.find(".modal-body input[name='id']").val(id);
    modal.find(".modal-body input[name='nombre']").val(nombre);
    
});


//Acción Guardar 
$("#ButtonUbicacionEquipoModalDelete").click(function (event) {
    event.preventDefault();
   // if ($('#ubicacionEquipoForm').valid()) {
        deleteModal();
   // } else {
   //     validator.focusInvalid();
   // }
});

function deleteModal(button) {
    var formData = $("#ubicacionEquipoDeleteForm").serialize();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "DELETE",
        headers: { 'X-CSRF-TOKEN': $('#ubicacionEquipoDeleteForm').val() },
        url: urlActual +  "/delete/",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            $('#ubicacionEquipoDeleteModal').modal('hide');
            ubicacionEquipoTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('La ubicación fue eliminada!!');
            
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            $('#ubicacionEquipoDeleteModal').modal('hide');
            //var errors = JSON.parse(errors.responseText);
         

          
        }

    });
}

