var movimientosTable = $('#movimientos-table').DataTable({
    "order": [[1, "desc"]],
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
        "sEmptyTable": "Ningún movimiento realizado actualmente",
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
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Descripción",
            "data": "descripcion",
            "width": "20%",
            "responsivePriority": 5,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },

        {
            "title": "Total",
            "data": "total",
            "width": "12%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                if(full.tipo_movimiento_id ==1) {
                    return ("+ " +  data);
                } else {
                    return ("- " + data);              
                }
            },
        },
        {
            "title": "Receptor",
            "data": "receptor",
            "width": "20%",
            "responsivePriority": 4,
            "render": function (data, type, full, meta) {
                return data;
            },
        },
        {
            "title": "Tipo Movimiento",
            "data": "tipo_movimiento_id",
            "width": "10%",
            "responsivePriority": 4,
            "render": function (data, type, full, meta) {
                if (data == 1) {
                    return 'Entrada';
                } else {
                    return 'Salida';
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
                    data = [full.id, $('#idCaja').val()];
                    if(full.isOpen == 1) {
                        if (full.tipo_movimiento_id == 2) {
                            return "<div class=' col-lg-4'>" +
                                "<a href='#' class='remove-movimiento'" + " data-method='delete' data-id='" + full.id + "' " + ">" +
                                "<i class='fas fa-trash' title='Eliminar movimiento'></i>" +
                                "</a>" + "</div>" +
                                "<div id='" + full.id + "' class='text-center'>" +
                                "<div class=' col-lg-4'>" +
                                "<a href='/movimientos/pdf/" + data + "'>" +
                                "<i class='fas fa-print' title='Imprimir recibo'></i>" +
                                "</a>" + "</div>";
                        } else {
                            if (full.total <= parseFloat($('#ultimoSaldo').val())) {
                                return "<div class=' col-lg-4'>" +
                                "<a href='#' class='remove-movimiento'" + " data-method='delete' data-id='" + full.id + "' " + ">" +
                                "<i class='fas fa-trash' title='Eliminar movimiento'></i>" +
                                "</a>" + "</div>";
                            } else {
                                return "<div class='col-lg-4'>" +
                                    "<i class='fas fa-warning'></i>" +
                                    "</div>"
                            }
                        }
                    } else {
                        return "<div class='col-lg-4'>" +
                                "<i class='fas fa-warning'></i>" +
                                "</div>"
                    }
                        
                   
                }

            },
            "responsivePriority": 1
        }]

});


