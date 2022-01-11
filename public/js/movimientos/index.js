var movsTable = $('#movs-table').DataTable({
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
            "width": "2%",
            "responsivePriority": 2,
            "render": function (data, type, full, meta) {
                    return (data);
            },
        },
        {
            "title": "Nombre.",
            "data": "nombre",
            "width": "5%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Tipo movimiento.",
            "data": "tipo_mov.tipo",
            "width": "5%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Tipo Cálculo.",
            "data": "tipo_calculo.tipo",
            "width": "5%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                if (full.tipo_calculo_id == 3) {
                    if (full.cantidad_ingreso_fijo != null) {
                        return (data + " | " + full.cantidad_ingreso_fijo);
                    } else {
                        return (data);
                    }
                } else if (full.tipo_calculo_id == 2) {
                    return (data + " | " + " *" + full.cantidad_multiplicar);
                } else if (full.tipo_calculo_id == 1){
                    console.log(parseFloat(full.porcentaje * 100).toFixed(2));
                   // console.log(full.porcentaje * 100);
                    return (data + " | " + parseFloat(full.porcentaje * 100).toFixed(2) + "%");
                } else {
                    return (data);
                }
            },
        },
        {
            "title": "Campo Afecto.",
            "data": "valor_p_c.dato",
            "width": "5%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                if (data != null) {
                    return (data);
                } else {
                    return ("/N");
                }
            },
        },
        {
            "title": "Auto / Manual.",
            "data": "valor_fijo.tipo",
            "width": "5%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                if (data != null) {
                    return (data);
                } else {
                    return ("/N");
                }
            },
        },
        {
            "title": "Acciones",
            "orderable": false,
            "width": "12%",
            "render": function (data, type, full, meta) {
                var rol_user = $("input[name='rol_user']").val();
                var urlActual = $("input[name='urlActual']").val();
                if (rol_user == 'Super-Administrador' || rol_user == 'Administrador') {
                    
                    if(full.tipo_calculo_id == 1) {
                        return "<div class='float-right col-lg-6'>" +
                            "<a href='" + urlActual + "/delete" + "' class='remove-mov'" + "data-method='delete'  data-toggle='modal' data-id='" + full.id + "' data-target='#modalConfirmarAccion' " + ">" +
                            "<i class='fas fa-trash' title='Eliminar Movimiento'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-left col-lg-6'>" +
                            "<a href='#' class='edit-mov' data-toggle='modal' data-target='#modalInEgresoEdit' data-id='" + full.id + "' data-tipom='" + full.tipo_movimiento_id + "' data-nombre='" + full.nombre + "' data-tipoc='" + full.tipo_calculo_id + "' data-valorpc='" + full.campo_pc_id + "' data-porcen='" + full.porcentaje + "'>" +
                            "<i class='fa fa-btn fa-edit' title='Editar movimiento'></i>" +
                            "</a>" + "</div>";
                    } else if (full.tipo_calculo_id == 2) {
                        return "<div class='float-right col-lg-6'>" +
                            "<a href='" + urlActual + "/delete" + "' class='remove-mov'" + "data-method='delete'  data-toggle='modal' data-id='" + full.id + "' data-target='#modalConfirmarAccion' " + ">" +
                            "<i class='fas fa-trash' title='Eliminar Movimiento'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-left col-lg-6'>" +
                            "<a href='#' class='edit-mov' data-toggle='modal' data-target='#modalInEgresoEdit' data-id='" + full.id + "' data-nombre='" + full.nombre + "' data-tipoc='" + full.tipo_calculo_id + "' data-tipom='" + full.tipo_movimiento_id + "'data-valorpc='" + full.campo_pc_id + "' data-multiplicar='" + full.cantidad_multiplicar +"'>" +
                            "<i class='fa fa-btn fa-edit' title='Editar movimiento'></i>" +
                            "</a>" + "</div>";

                    } else {
                        return "<div class='float-right col-lg-6'>" +
                            "<a href='" + urlActual + "/delete" + "' class='remove-mov'" + "data-method='delete'  data-toggle='modal' data-id='" + full.id + "' data-target='#modalConfirmarAccion' " + ">" +
                            "<i class='fas fa-trash' title='Eliminar Movimiento'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-left col-lg-6'>" +
                            "<a href='#' class='edit-mov' data-toggle='modal' data-target='#modalInEgresoEdit' data-id='" + full.id + "' data-nombre='" + full.nombre + "' data-tipoc='" + full.tipo_calculo_id + "' data-tipom='" + full.tipo_movimiento_id + "'data-valoram='" + full.campo_am_id + "'data-cant='" + full.cantidad_ingreso_fijo + "'>" +
                            "<i class='fa fa-btn fa-edit' title='Editar movimiento'></i>" +
                            "</a>" + "</div>";
                    }
                    
                }
            },
            "responsivePriority": 1
        }
    ]

    
});




