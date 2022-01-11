var estadosTallerTable = $('#estados-taller-table').DataTable({
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
            extend: "excelHtml5",
            filename: 'estados_de_taller',

        },
        {
            extend: 'csvHtml5',
            filename: 'estados_de_taller',
        },
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
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            }
        },
        {
            "title": "Nombre",
            "data": "nombre",
            "width": "20%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Acciones",
            "orderable": false,
            "width": "10%",
            "render": function (data, type, full, meta) {
                var rol_user = $("input[name='rol_user']").val();
                var urlActual = $("input[name='urlActual']").val();
                    return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-left col-lg-6'>" +
                        "<a href='#' class='edit-estadosTaller' data-toggle='modal' data-target='#estadosTallerUpdateModal' data-id='" + full.id + "' data-nombre='" + full.nombre + "' >" +
                        "<i class='fa fa-btn fa-edit' title='Editar Estado de taller'></i>" +
                        "</a>" + "</div>" +
                        "<div class='float-right col-lg-6'>" +
                        "<a href='#' class='remove-estadosTaller'" + "data-method='delete'  data-toggle='modal' data-id='" + full.id + "' data-target='#modalConfirmarAccion' " + ">" +
                        "<i class='fas fa-trash' title='Eliminar Estado de taller'></i>" +
                        "</a>" + "</div>";  
               
            },
            "responsivePriority": 5
        }
    ]
});

//Activar Estado de Taller
$(document).on('click', 'a.activar-estadosTaller', function (e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    alertify.confirm('Activar Estado taller', 'Esta seguro de activar el estado',
        function () {
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                estadosTallerTable.ajax.reload();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success('Estado de taller activado con Éxito!!');
            });
        }
        , function () {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Cancelar')
        });
});
