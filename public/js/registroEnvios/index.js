var enviosTable = $('#envios-table').DataTable({
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
            filename: 'envíosEquipo',
        },
        {
            extend: 'csvHtml5',
            filename: 'envíosEquipo',
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
            "title": "No",
            "data": "id",
            "width": "3%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "No. Envío",
            "data": "no_envio",
            "width": "3%",
            "responsivePriority": 5,
            "render": function (data, type, full, meta) {
                return ("00" + data + "-" + full.anio);
            },
        },
        {
            "title": "No. Orden Trabajo",
            "data": "no_orden_trabajo",
            "width": "8%",
            "responsivePriority": 4,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Equipo",
            "data": "equipo",
            "width": "3%",
            "responsivePriority": 5,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Dirección",
            "data": "direccion",
            "width": "8%",
            "responsivePriority": 5,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        // {
        //     "title": "Observaciones",
        //     "data": "observaciones",
        //     "width": "15%",
        //     "responsivePriority": 3,
        //     "render": function (data, type, full, meta) {
        //         return data;
        //     },
        // },
        {
            "title": "Receptor",
            "data": "receptor",
            "width": "7%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Persona Responsable",
            "data": "nombres",
            "width": "7%",
            "responsivePriority": 5,
            "render": function (data, type, full, meta) {
                return (data + " " + full.apellidos);
            },
        },
        {
            "title": "Estado",
            "data": "estado",
            "width": "10%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
               return data;
            },
        },
        {
            "title": "Acciones",
            "orderable": false,
            "width": "20%",
            "render": function (data, type, full, meta) {
                var rol_user = $("input[name='rol_user']").val();
                var urlActual = $("input[name='urlActual']").val();
                if (rol_user == 'Super-Administrador' || rol_user == 'Administrador') {
                    //listo
                    if (full.estado_envio_id == 1) {
                        return "<div id='" + full.id + "' class='text-center'>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='/enviosEquipo/enCamino/" + full.id + "'class='envio-enRuta'" + ">" +
                            "<i class='fas fa-road' title='Envío en ruta'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-left col-lg-2'>" +
                            "<a href='" + urlActual + "/edit/" + full.id + "' class='edit-envio' >" +
                            "<i class='fas fa-edit' title='Editar envío'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='/enviosEquipo/pdf/" + full.id + "'class='envio-pdf'" + ">" +
                            "<i class='fas fa-file-download' title='Generar PDF'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='#' class='envio-remove'" + " data-method='delete' data-id='" + full.id + "' " + ">" +
                            "<i class='fas fa-thumbs-down' title='Anular Envío'></i>" +
                            "</a>" + "</div>";
                    //ruta
                    } else if (full.estado_envio_id == 2) {
                        return "<div class='float-right col-lg-2'>" +
                            "<a href='#' class='envio-modal' data-toggle='modal' data-target='#envioModal' data-id='" + full.id + "'  data-receptor='" + full.receptor + "' > " +
                            "<i class='fas fa-hand-paper' title='Confirmar estado entregado'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='/enviosEquipo/rechazar/" + full.id + "'class='envio-rechazado'" + ">" +
                            "<i class='far fa-thumbs-down' title='Confirmar Rechazo'></i>" +
                            "</a>" + "</div>";
                    //entregado
                    } if (full.estado_envio_id == 3) {
                        return "<div id='" + full.id + "' class='text-center'></div>";
                    //rechazado
                    } if (full.estado_envio_id == 4) {
                        return "<div class='float-right col-lg-2'>" +
                            "<a href='/enviosEquipo/recibir/" + full.id + "'class='envio-recepcion'" + ">" +
                            "<i class='fas fa-archive' title='Confirmar Recepción'></i>" +
                            "</a>" + "</div>"; 
                    //recibido
                    } else if (full.estado_envio_id == 5){
                        return "<div id='" + full.id + "' class='text-center'></div>";
                    //anulado
                    } else {
                        return "<div id='" + full.id + "' class='text-center'></div>";

                    }
                } else {
                    return "<div class='text-center'></div>";

                }


            },
            "responsivePriority": 1
        }]

});

//Envío impreso
$(document).on('click', 'a.envio-enRuta', function (e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    console.log($this.attr('href'));

    alertify.confirm('Confirmar que el envío ya está en ruta', 'Envío de equipo en ruta',
        function () {
            $('.loader').fadeIn();
            $.post({
                type: 'PUT',
                url: $this.attr('href'),
            }).done(function (data) {
                $('.loader').fadeOut(225);
                enviosTable.ajax.reload();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success('el envío está en ruta!!');
            });
        }
        , function () {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Cancelar')
        });
});
//
//Envío rechazado
$(document).on('click', 'a.envio-rechazado', function (e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    console.log($this.attr('href'));

    alertify.confirm('Confirmar que el envío ha sido rechazado', 'Envío de equipo rechazado',
        function () {
            $('.loader').fadeIn();
            $.post({
                type: 'PUT',
                url: $this.attr('href'),
            }).done(function (data) {
                $('.loader').fadeOut(225);
                enviosTable.ajax.reload();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success('el envío se ha rechazado correctamente!!');
            });
        }
        , function () {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Cancelar')
        });
});
//
//Envío devuelto
$(document).on('click', 'a.envio-recepcion', function (e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    console.log($this.attr('href'));

    alertify.confirm('Confirmar que el envío está en recepción', 'Envío de equipo devuelto',
        function () {
            $('.loader').fadeIn();
            $.post({
                type: 'PUT',
                url: $this.attr('href'),
            }).done(function (data) {
                $('.loader').fadeOut(225);
                enviosTable.ajax.reload();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success('el envío ha sido recibido correctamente!!');
            });
        }
        , function () {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Cancelar')
        });
});