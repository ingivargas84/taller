var detalleCompraTable = $('#detalle-compra-table').DataTable({
    "ajax": {
        "type": "GET",
        "url": "/compras/getWeakJson/" + $("input[name='id']").val() + '/',
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
            "title": "Fecha.",
            "data": "fecha_ingreso",
            "width": "10%",
            "responsivePriority": 2,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Producto",
            "data": "producto.nombre",
            "width": "20%",
            "responsivePriority": 2,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Cantidad.",
            "data": "cantidad",
            "width": "6%",
            "responsivePriority": 2,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Precio de compra.",
            "data": "precio_compra",
            "width": "6%",
            "responsivePriority": 2,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Subtotal.",
            "data": "subtotal",
            "width": "10%",
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
  
                    if (full.movimiento_producto.existencias === full.cantidad) {
                        return "<div id='" + full.id + "' class='text-center'>" +
                            "<div class='float-right col-lg-6'>" +
                            "<a href='#' class='remove-producto'" + "data-method='delete'  data-toggle='modal' data-id='" + full.id + "' data-target='#modalConfirmarAccion' " + ">" +
                            "<i class='fas fa-trash' title='Eliminar producto'></i>" +
                            "</a>" + "</div>";
                    } else {
                        return "<div class='text-center'>" + "</div>";
                    }
                    
            },
            "responsivePriority": 5
        }]

});