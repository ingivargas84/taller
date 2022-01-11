var ordenTaller = $('#orden-taller-table').DataTable({
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
    "columns": [ {
            "title": "No.",
            "data": "id",
            "width": "10%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            }
        },
        {
            "title": "Comprobante",
            "data": "no_comprobante",
            "width": "10%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Fecha Ingreso",
            "data": "fecha_orden",
            "width": "10%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Equipo",
            "data": "equipo",
            "width": "15%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Estado OT",
            "data": "estado",
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
                    if(full.ubicacion == 'Taller' && full.estado == 'Enviado Taller') {
                        return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-right col-lg-3'>" +
                        "<a href='/taller/recibirorden/"+ full.id +"' class='recibe-orden'" + ">" +
                        "<i class='fas fa-hand-holding' title='Recibir Orden a Taller'></i>" +
                        "</div>" +
                        "<div class='float-left col-lg-3'>" +
                            "<a href='/ordenequipo/show/" + full.id + "' class='detalle-ordentrabajo' >" +
                        "<i class='fa fa-scroll' title='Bitácora'></i>" + "</div>"
                        "</a>" + "</div>";
                    }else if(full.ubicacion == 'Taller' && full.estado == 'Recibido Taller') {
                        return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-left col-lg-3'>" +
                        "<a href='/taller/envio/" + full.id + "' class='crear-diagnostico' >" +
                        "<i class='fas fa-arrow-right' title='Enviar Orden al Asesor'></i>" +
                        "</div>" +
                        "<div class='float-left col-lg-3'>" +
                        "<a href='/taller/new3/" + full.id + "' class='crear-diagnostico' >" +
                        "<i class='fa fa-btn fa-edit' title='Crear o Editar Diagnóstico Taller'></i>" +
                        "</div>" +
                        "<div class='float-left col-lg-3'>" +
                        "<a href='/taller/irreparable/" + full.id + "' class='irreprable' >" +
                        "<i class='fas fa-skull-crossbones' title='Declarar Irreparable'></i>" +
                        "</div>" +
                        "<div class='float-left col-lg-3'>" +
                        "<a href='/ordenequipo/show/" + full.id + "' class='detalle-ordentrabajo' >" +
                        "<i class='fa fa-scroll' title='Bitácora'></i>" + "</div>" +
                        "</a>" + "</div>";
                    }else if(full.ubicacion == 'Taller' && full.estado == 'Enviado Taller 2') {
                        return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-right col-lg-3'>" +
                        "<a href='/taller/recibirorden3/"+ full.id +"' class='recibe-orden3'" + ">" +
                        "<i class='fas fa-hand-point-right' title='Recibir Orden en Taller 2'></i></div>" +
                        "<div class='float-left col-lg-3'>" +
                        "<a href='/ordenequipo/show/" + full.id + "' class='detalle-ordentrabajo' >" +
                        "<i class='fa fa-scroll' title='Bitácora'></i>" +
                            "</a>" + "</div></div>";
                    }else if(full.ubicacion == 'Taller' && full.estado == 'Recibido Taller 2') {
                        return "<div id='" + full.id + "' class='text-center'>" +
                        "<div class='float-left col-lg-3'>" +
                        "<a href='/taller/enviorecepcion3/" + full.id + "' class='envio-recepcion3' >" +
                        "<i class='fas fa-arrow-right' title='Enviar Orden a Recepción para Entrega y Cobro'></i>" +
                        "</div>" +
                        "<div class='float-left col-lg-3'>" +
                        "<a href='/taller/new5/" + full.id + "' class='registra-reparacion' >" +
                        "<i class='fas fa-check-double' title='Registro Reparacion Taller 2'>" +
                        "</i></div>" +
                        "<div class='float-left col-lg-3'>" +
                        "<a href='/taller/irreparable/" + full.id + "' class='irreprable' >" +
                        "<i class='fas fa-skull-crossbones' title='Declarar Irreparable'></i>" +
                        "</div>" +
                        "<div class='float-left col-lg-3'>" +
                        "<a href='/ordenequipo/show/" + full.id + "' class='detalle-ordentrabajo' >" +
                        "<i class='fa fa-scroll' title='Bitácora'></i>" +
                        "</a>" + "</div></div>";
                    }else{
                        return "";
                    }
            },
            "responsivePriority": 5
        }]
});
