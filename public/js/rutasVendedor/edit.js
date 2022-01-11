var validator = $("#RutaUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	onclick: false,
	//onfocusout: false,
	rules: {
		observaciones_edit: {
			required: true,
		},

	},
	messages: {
		observaciones_edit: {
			required: "Ingrese el motivo de visita",
		},
	}
});

$('#modalUpdateRuta').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre = button.data('nombre');
	var modal = $(this);
	$.getJSON('misRutas/' + id, function (data) {
		console.log(data[0].observaciones);
			$('#observaciones_edit').val(data[0].observaciones);
	});
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre']").val(nombre);

 }); 

function BorrarFormularioUpdate() {
	$("#RutaUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonRutaModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#RutaUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	var formData = $("#RutaUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$('.loader').fadeIn();
	$.ajax({
		type: "PUT",
		headers: { 'X-CSRF-TOKEN': $('#tokenRutaEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			BorrarFormularioUpdate();
			$('#modalUpdateRuta').modal("hide");
			rutasTable.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Ruta Editada con Éxito!!');
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#RutaUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
	{
		$('#modalUpdateRuta').modal('show');
	}

$('#modalUpdateRuta').on('hide.bs.modal', function(){
	$("#RutaUpdateForm").validate().resetForm();
	document.getElementById("RutaUpdateForm").reset();
		window.location.hash = '#';

	});

$('#modalUpdateRuta').on('shown.bs.modal', function(){
		window.location.hash = '#edit';

	}); 


