var pmovimientosTable = $('#pmovimientos-table').DataTable({
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
            filename: 'movimientos',
        },
        {
            extend: 'csvHtml5',
            filename: 'movimientos',
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
            "width": "5%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Fecha.",
            "data": "fecha",
            "width": "15%",
            "responsivePriority": 5,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Saldo",
            "data": "saldo",
            "width": "20%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Estado",
            "data": "estado_caja_id",
            "width": "20%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                if(data==1) {
                    return 'Abierto';
                } else {
                    return 'Cerrada';
                }
            },
        },
        {
            "title": "Acciones",
            "orderable": false,
            "width": "40%",
            "render": function (data, type, full, meta) {
                var rol_user = $("input[name='rol_user']").val();
                var urlActual = $("input[name='urlActual']").val();
                if (rol_user == 'Super-Administrador' || rol_user == 'Administrador') {
                    return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class=' col-lg-4'>" +
                        "<a href='" + urlActual + "/show/" + full.id + "' class='show-movimiento' >" +
                        "<i class='fas fa-info-circle' title='detalle movimientos'></i>" +
                        "</a>" + "</div>" +
                        "<div class=' col-lg-4'>" +
                        "<a href='" + urlActual + "/singleReport/" + full.id + "' class='print-movimiento' >" +
                        "<i class='fas fa-print' title='imprimir movimientos'></i>" +
                        "</a>" + "</div>";
                }

            },
            "responsivePriority": 1
        }]

});


