var detalleCotizacionTable = $('#detalle-cotizacion-table').DataTable({
    "ajax": {
        "type": "GET",
        "url": "/cotizaciones/getWeakJson/" + $("input[name='id']").val() + '/',
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
            text: 'Generar PDF',
            action: function (e, dt, node, config) {
                window.location = "/cotizaciones/pdf/" + $('#idCot').val();
            }
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
            "title": "Producto / Servicio.",
            "data": "isProduct",
            "width": "10%",
            "responsivePriority": 2,
            "render": function (data, type, full, meta, row) {
                if(data == 1) {
                    return full.producto.nombre;

                } else {
                   return full.servicio.nombre;
                }
            }
        },
        {
            "title": "Cantidad",
            "data": "cantidad",
            "width": "20%",
            "responsivePriority": 2,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Precio.",
            "data": "precio",
            "width": "6%",
            "responsivePriority": 2,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Subtotal.",
            "data": "subtotal",
            "width": "6%",
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
                        "<div class='float-right col-lg-6'>" +
                        "<a href='#' class='remove-bien'" + "data-method='delete'  data-toggle='modal' data-id='" + full.id + "' data-target='#modalConfirmarAccion' " + ">" +
                        "<i class='fas fa-trash' title='Eliminar Producto / Servicio'></i>" +
                        "</a>" + "</div>";
                

            },
            "responsivePriority": 5
        }]

});