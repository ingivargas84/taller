var productos_table = $('#productos-table').DataTable({
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
            filename: 'productos',
        },
        {
            extend: 'csvHtml5',
            filename: 'productos',
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
            "title": "Codigo",
            "data": "codigo",
            "width": "20%",
            "responsivePriority": 2,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Producto",
            "data": "nombre",
            "width": "20%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Precio de Venta",
            "data": "precio_venta",
            "width": "15%",
            "responsivePriority": 1,
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
            "width": "10%",
            "render": function (data, type, full, meta) {
                var rol_user = $("input[name='rol_user']").val();
                var urlActual = $("input[name='urlActual']").val();
                if (full.estado_id == 1) {
                    return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-left col-lg-4'>" +
                        "<a href='" + urlActual + "/edit/" + full.id + "' class='edit-producto' >" +
                        "<i class='fa fa-btn fa-edit' title='Editar Producto'></i>" +
                        "</a>" + "</div>" +
                        "<div class='float-right col-lg-4'>" +
                        "<a href='#' class='remove-producto' data-method='delete' data-id='" + full.id + "' data-target='#modalConfirmarAccion' data-toggle='modal'>" +
                        "<i class='fa fa-thumbs-down' title='Desactivar Producto'></i>" +
                        "</a>" + "</div>";

                } else {
                    if (rol_user == 'Super-Administrador' || rol_user == 'Administrador') {
                        return "<div id='" + full.id + "' class='text-center'>" +
                            "<div class='float-right col-lg-6'>" +
                            "<a href='" + urlActual + "/" + full.id + "/activar' class='activar-producto'" + "data-method='post' data-id='" + full.id + "' >" +
                            "<i class='fa fa-thumbs-up' title='Activar Producto'></i>" +
                            "</a>" + "</div>";
                    } else {
                        return "<div id='" + full.id + "' class='text-center'>" + "</div>";
                    }

                }

            },
            "responsivePriority": 5
        }

    ]

});

//Activar producto
$(document).on('click', 'a.activar-producto', function (e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    alertify.confirm('Activar Producto', 'Esta seguro de activar el producto',
        function () {
            $('.loader').fadeIn();
            console.log('HOla');
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                productos_table.ajax.reload();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success('Producto Activado con Éxito!!');
            });
        }
        , function () {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Cancelar')
        });
});


