var ordenEquipo = $('#orden-equipo-table').DataTable({
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
            filename: 'ordenes_equipo'
        },
        {
            extend: 'csvHtml5',
            filename: 'ordenes_equipo'
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
    "columns": [{
            "title": "#",
            "data": "id",
            "width": "5%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Comp",
            "data": "no_comprobante",
            "width": "5%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Fecha",
            "data": "fecha_orden",
            "width": "5%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Cliente",
            "data": "cliente",
            "width": "10%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Equipo",
            "data": "equipo",
            "width": "10%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Tipo Trabajo",
            "data": "tipo_trabajo",
            "width": "10%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Asesor/Vendedor",
            "data": "asesor",
            "width": "10%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Estado",
            "data": "estado",
            "width": "10%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },

        {
            "title": "Ubicacion",
            "data": "ubicacion",
            "width": "5%",
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
                        if(full.ubicacion == 'Recepción' && full.estado == 'Recepción') {
                        return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-center col-lg-3'>" +
                        "<a href='" + urlActual + "/edit/" + full.id + "' class='edit-ordentrabajo' >" +
                        "<i class='fa fa-btn fa-edit' title='Editar Orden Trabajo'></i>" +
                        "</a>" + "</div>" +
                        "<div class='float-center col-lg-3'>" +
                        "<a href='#' class='remove-ordenequipo'" + "data-method='delete' data-toggle='modal' data-id='" + full.id + "' data-target='#modalConfirmarAccion' " + ">" +
                        "<i class='fa fa-thumbs-down' title='Borrar Orden de Trabajo'></i>" +
                        "</a>" + "</div>" +
                        "<div class='float-center col-lg-3'>" +
                        "<a href='/ordenequipo/ttaller/"+ full.id +"' class='enviar-ordent'" + ">" +
                        "<i class='fas fa-arrow-right' title='Enviar Orden a Taller'></i>" +
                        "</a>" + "</div>" +
                        "<div class='float-center col-lg-3'>" +
                        "<a href='" + urlActual + "/show/" + full.id + "' class='detalle-ordentrabajo' >" +
                        "<i class='fa fa-scroll' title='Bitácora'></i>" +
                        "</a>" + "</div>";
                    }else if(full.ubicacion == 'Recepción' && full.estado == 'Enviado Recepción Llamada') {
                        return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-right col-lg-6'>" +
                        "<a href='/ordenequipo/recibirorden2/"+ full.id +"' class='recibe-orden2'" + ">" +
                        "<i class='fas fa-hand-holding' title='Recibir Orden desde Taller'></i>" +
                        "</div>" +
                        "<div class='float-left col-lg-6'>" +
                        "<a href='" + urlActual + "/show/" + full.id + "' class='detalle-ordentrabajo' >" +
                        "<i class='fa fa-scroll' title='Bitácora'></i>" +
                        "</a>" + "</div></div>";
                    }else if(full.ubicacion == 'Recepción' && full.estado == 'Recibido Recepción Llamada') {
                        return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-center col-lg-3'>" +
                        "<a href='/ordenequipo/enviataller2/"+ full.id +"' class='envia-taller2'" + ">" +
                        "<i class='fas fa-arrow-right' title='Envia Orden a Taller'></i>" +
                        "</div>" +
                        "<div class='float-center col-lg-3'>" +
                        "<a href='/ordenequipo/new2/" + full.id + "' class='crear-pagoytel' >" +
                        "<i class='fas fa-pencil-ruler' title='Registro Total Pago y Registro Telefónico'></i>" + "</div>" +
                        "<div class='float-center col-lg-3'>" +
                        "<a href='/ordenequipo" + "/show/" + full.id + "' class='detalle-ordentrabajo' >" +
                        "<i class='fa fa-scroll' title='Bitácora'></i>" +
                        "</a>" + "</div>" + "</div>";
                    }else if(full.ubicacion == 'Recepción' && full.estado == 'Enviada a Recepción Entrega') {
                        return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-right col-lg-6'>" +
                        "<a href='/ordenequipo/recibirorden3/"+ full.id +"' class='recibe-orden3'" + ">" +
                        "<i class='fas fa-handshake' title='Recibir Orden desde Taller Finalizada'></i></div>" +
                        "<div class='float-left col-lg-6'>" +
                        "<a href='/ordenequipo" + "/show/" + full.id + "' class='detalle-ordentrabajo' >" +
                        "<i class='fa fa-scroll' title='Bitácora'></i>" +
                        "</a>" + "</div></div>";
                    }else if(full.ubicacion == 'Recepción' && full.estado == 'Lista para Entregar') {
                        return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-right col-lg-6'>" +
                        "<a href='/ordenequipo/recibirorden4/"+ full.id +"' class='entregaequipoycobro'" + ">" +
                        "<i class='fas fa-paper-plane' title='Entregar Equipo y Registrar Cobro'></i>" +
                        "</a></div>"  +
                        "<div class='float-left col-lg-6'>" +
                        "<a href='/ordenequipo" + "/show/" + full.id + "' class='detalle-ordentrabajo' >" +
                        "<i class='fa fa-scroll' title='Bitácora'></i>" +
                        "</a>" + "</div></div>";
                    }else if(full.ubicacion == 'Recepción' && full.estado == 'Irreparable') {
                        return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-right col-lg-6'>" +
                        "<a href='/ordenequipo/recibirorden4/"+ full.id +"' class='entregaequipoycobro'" + ">" +
                        "<i class='fas fa-paper-plane' title='Entregar Equipo y Registrar Cobro'></i>" +
                        "</a></div>"  +
                        "<div class='float-left col-lg-6'>" +
                        "<a href='/ordenequipo" + "/show/" + full.id + "' class='detalle-ordentrabajo' >" +
                        "<i class='fa fa-scroll' title='Bitácora'></i>" +
                        "</a>" + "</div></div>";
                    }else if(full.ubicacion == 'Recepción' && full.estado == 'Cobrada y Entregada'){
                        if (full.has_guarantee == 0) {
                            return "<div id='" + full.id + "' class='text-center'>" +
                                "<div class='float-right col-lg-4'>" +
                                "<a href='/ordeneequipo/pdf/" + full.id + "' class='entregaequipoycobro'" + ">" +
                                "<i class='fas fa-print' title='Imprimir Cobro'></i>" +
                                "</div>" +
                                "<div class='float-right col-lg-4'>" +
                                "<a href='#' data-target='#garantiaModal' onclick='takeID(" + full.id + ")' data-toggle='modal' class='garantia'" + ">" +
                                "<i class='fas fa-file' title='Generar Garantía'></i>" +
                                "</div>" +
                                "<div class='float-left col-lg-4'>" +
                                "<a href='/ordenequipo" + "/show/" + full.id + "' class='detalle-ordentrabajo' >" +
                                "<i class='fa fa-scroll' title='Bitácora'></i>" +
                                "</a>" + "</div>";
                        } else if (full.has_guarantee == 1) {
                            return "<div id='" + full.id + "' class='text-center'>" +
                                "<div class='float-right col-lg-4'>" +
                                "<a href='/ordeneequipo/pdf/" + full.id + "' class='entregaequipoycobro'" + ">" +
                                "<i class='fas fa-print' title='Imprimir Orden de Cobro'></i>" +
                                "</div>" +
                                "<div class='float-right col-lg-4'>" +
                                "<a href='/ordenequipo/garantia/pdf/" + full.id + "' class='garantia'" + ">" +
                                "<i class='fas fa-file-pdf' title='Generar Garantía PDF'></i>" +
                                "</div>" +
                                "<div class='float-left col-lg-4'>" +
                                "<a href='/ordenequipo" + "/show/" + full.id + "' class='detalle-ordentrabajo' >" +
                                "<i class='fa fa-scroll' title='Bitácora'></i>" +
                                "</a>" + "</div>";
                        }
                    }else{
                        return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-left col-lg-12'>" +
                        "<a href='/ordenequipo"  + "/show/" + full.id + "' class='detalle-ordentrabajo' >" +
                        "<i class='fa fa-scroll' title='Bitácora'></i>" +
                        "</a>" + "</div>" + "</div>";
                    }
            },
            "responsivePriority": 1
        }]
});


