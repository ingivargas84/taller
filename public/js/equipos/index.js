var equipoTable = $('#equipo-table').DataTable({
        "ajax": {
            "type": "POST",
            "url": "equipos/getJson",
            "data": function (json) { return JSON.stringify({ "Sql": 12 }); },
            "contentType": "application/json; charset=utf-8",
            "dataType": "json",
            "processData": true,
        },
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
            {
                extend: 'excelHtml5',
                filename: 'equipos',
            },
            {
                extend: 'csvHtml5',
                filename: 'equipos',
            }
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

        "columns": [
            {
                "title": "No.",
                "data": "id",
                "width": "10%",
                "responsivePriority": 2,
                "render": function (data, type, full, meta) {
                    return (data);
                },
            },
            {
                "title": "Equipo",
                "data": "equipo",
                "width": "20%",
                "responsivePriority": 2,
                "render": function (data, type, full, meta) {
                    return (data);
                },
            },
            {
                "title": "Ubicacion",
                "data": "ubicacion.ubicacion",
                "width": "20%",
                "responsivePriority": 2,
                "render": function (data, type, full, meta) {
                    return (data);
                },
            },
            {
                "title": "Acciones",
                "orderable": false,
                "width": "20%",
                "render": function (data, type, full, meta) {
                var rol_user = $("input[name='rol_user']").val();
                var urlActual = $("input[name='urlActual']").val();
                    return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-left col-lg-6'>" +
                        "<a href='#' class='edit-equipo' data-toggle='modal' data-target='#equipoUpdateModal' data-id='" + full.id + "' data-nombre='" + full.equipo + "'data-desc='" + full.descripcion + "' data-idubi='" + full.ubicacion.id + "' data-ubi='" + full.ubicacion.ubicacion + "'>" +
                        "<i class='fa fa-btn fa-edit' title='Editar equipo'></i>" +
                        "</a>" + "</div>" +
                        "<div class='float-right col-lg-6'>" +
                        "<a href='#' class='remove-equipo'" + "data-method='delete'  data-toggle='modal' data-id='" + full.id + "' data-target='#modalConfirmarAccion' " + ">" +
                        "<i class='fas fa-trash' title='Eliminar Equipo'></i>" +
                        "</a>" + "</div>";
                },
                "responsivePriority": 5
            }]

    });

//Activar Equipo
$(document).on('click', 'a.activar-equipo', function (e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    alertify.confirm('Activar Equipo', 'Esta seguro de activar el equipo',
        function () {
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                equipoTable.ajax.reload();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success('Equipo activado con Éxito!!');
            });
        }
        , function () {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Cancelar')
        });
});