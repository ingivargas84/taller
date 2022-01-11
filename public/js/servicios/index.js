var servicios_table = $('#servicios-table').DataTable({
    //"ajax": "/servicios/getJson",
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',

    lengthMenu: [
        [10, 25, 50, -1],
        ['10 filas', '25 filas', '50 filas', 'Mostrar todo']
    ],

    "buttons": [
        'pageLength',
        'excelHtml5',
        'csvHtml5'
    ],

    "paging": true,
    "language": {
        "sdecimal": ".",
        "sthousands": ",",
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'desc'],

    "columns": [{
        "title": "No.",
        "data": "id",
        "width": "15%",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Servicio",
        "data": "nombre",
        "width": "20%",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
        {
            "title": "Precio",
            "data": "precio",
            "width": "20%",
            "responsivePriority": 2,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Estado",
            "data": "estado_id",
            "width": "10%",
            "responsivePriority": 2,
            "render": function (data, type, full, meta) {
                if (data == 1) {
                    return 'Activo';
                } else {
                    return 'Inactivo';
                }
            },
        },

    {
        "title": "Acciones",
        "orderable": false,
        "width": "20%",
        "render": function (data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();
            if(full.estado_id == 1) {
                return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-left col-lg-6'>" +
                    "<a href='#' class='edit-servicio' data-toggle='modal' data-target='#servicioModalUpdate' data-id='" + full.id + "' data-nombre='" + full.nombre + "' data-desc='" + full.precio + "'>" +
                    "<i class='fa fa-btn fa-edit' title='Editar Servicio'></i>" +
                    "</a>" + "</div>" +
                    "<div class='float-right col-lg-6'>" +
                    "<a href='#' class='remove-servicio'" + "data-method='delete'  data-toggle='modal' data-id='" + full.id + "' data-target='#modalConfirmarAccion' " + ">" +
                    "<i class='fa fa-thumbs-down' title='Desactivar Servicio'></i>" +
                    "</a>" + "</div>";

            } else {
                    return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-right col-lg-6'>" +
                        "<a href='" + urlActual + "/" + full.id + "/activar' class='activar-servicio'" + "data-method='post' data-id='" + full.id + "' >" +
                        "<i class='fa fa-thumbs-up' title='Activar Servicio'></i>" +
                        "</a>" + "</div>";
               
            }
         
        },
        "responsivePriority": 5
    }]

});

function confirmarAccion(button) {
    var formData = $("#ConfirmarAccionForm").serialize();
    var id = $("#idConfirmacion").val();
    var urlActual = $("input[name='urlActual']").val();
    $('.loader').fadeIn();
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#tokenReset').val() },
        url: urlActual + "/" + id + "/delete",
        data: formData,
        dataType: "json",
        success: function (data) {
            $('.loader').fadeOut(225);
            BorrarFormularioConfirmar();
            $('#modalConfirmarAccion').modal("hide");
            servicios_table.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('El Servicio se desactivó Correctamente!!');
        },
        error: function (errors) {
            $('.loader').fadeOut(225);
            if (errors.responseText != "") {
                var errors = JSON.parse(errors.responseText);
                if (errors.password_actual != null) {
                    $("input[name='password_actual'] ").after("<label class='error' id='ErrorPassword_actual'>" + errors.password_actual + "</label>");
                }
                else {
                    $("#ErrorPassword_actual").remove();
                }
            }

        }

    });
}

//Desactivar Servicio
$(document).on('click', 'a.remove-servicio', function(e) {
    e.preventDefault(); // does not go through with the link.
    var urlActual = $("input[name='urlActual']").val();
    var $this = $(this);
    var id = $this.data('id');
    alertify.confirm('Desactivar servicio', 'Esta seguro de desactivar el servicio',
        function(){
            $.post({
                type: 'DELETE',
                //url: $this.attr('href'),
                url: urlActual + "/delete",
                data: { 'id': id },
            }).done(function (data) {
                servicios_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Servicio Desactivado con Éxito!!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center');
            alertify.error('Cancel')
        });
});



//Activar Servicio
$(document).on('click', 'a.activar-servicio', function (e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    alertify.confirm('Activar Servicio', 'Esta seguro de activar el servicio',
        function () {
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                servicios_table.ajax.reload();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success('Servicio Activado con Éxito!!');
            });
        }
        , function () {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Cancelar')
        });
});