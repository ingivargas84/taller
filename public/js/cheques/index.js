var chequesTable = $('#cheques-table').DataTable({
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
            filename: 'cheques',
        },
        {
            extend: 'csvHtml5',
            filename: 'cheques',
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
            "width": "3%",
            "responsivePriority": 5,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "No Cheque.",
            "data": "no_cheque",
            "width": "3%",
            "responsivePriority": 5,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
    {
        "title": "Fecha.",
        "data": "fecha",
        "width": "8%",
        "responsivePriority": 5,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
    {
        "title": "Cantidad",
        "data": "cantidad",
        "width": "8%",
        "responsivePriority": 3,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
    {
        "title": "Cuenta Bancaria",
        "data": "cuenta_bancaria.no_cuenta",
        "width": "15%",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (full.cuenta_bancaria.nombre_cuenta + '-' + data + ", " + full.cuenta_bancaria.banco.banco);
        },
    },
    {
        "title": "Receptor",
        "data": "receptor",
        "width": "7%",
        "responsivePriority": 4,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
        {
            "title": "Estado",
            "data": "estado_cheque_id",
            "width": "10%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                if(data == 1) {
                    return 'Creado';
                } else if(data == 2) {
                    return 'Impreso';
                } else if(data == 3) {
                    return "Entregado";
                } else if(data == 4) {
                    return 'Anulado';
                } else {
                    return "Cobrado";
                }
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
                if(full.estado_cheque_id == 1) {
                    if(full.voucher == null) {
                        return "<div id='" + full.id + "' class='text-center'>" +
                            "<div class='float-left col-lg-2'>" +
                            "<a href='#' class='show-cheque' data-toggle='modal' data-target='#infoCheque' data-id='" + full.id + "' > " +
                            "<i class='fas fa-info-circle' title='Ver más'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-left col-lg-2'>" +
                            "<a href='" + urlActual + "/edit/" + full.id + "' class='edit-cheque' >" +
                            "<i class='fa fa-btn fa-edit' title='Editar Cheque'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='#' class='cheque-printed'" + "data-id='" + full.id + "' " + ">" +
                            "<i class='fas fa-print' title='Generar Cheque en PDF'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-left col-lg-2'>" +
                            "<a href='#' class='get-voucher' data-toggle='modal' data-target='#voucherModal' data-method='post' data-id='" + full.id + "' data-no_cheque='" + full.no_cheque + "'>" +
                            "<i class='far fa-file' title='Generar voucher'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='#' class='remove-cheque'" + " data-method='delete' data-id='" + full.id + "' " + ">" +
                            "<i class='fas fa-thumbs-down' title='Anular Cheque'></i>" +
                            "</a>" + "</div>";
                    } else {
                        return "<div id='" + full.id + "' class='text-center'>" +
                            "<div class='float-left col-lg-2'>" +
                            "<a href='#' class='show-cheque' data-toggle='modal' data-target='#infoCheque' data-id='" + full.id + "' > " +
                            "<i class='fas fa-info-circle' title='Ver más'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-left col-lg-2'>" +
                            "<a href='" + urlActual + "/edit/" + full.id + "' class='edit-cheque' >" +
                            "<i class='fa fa-btn fa-edit' title='Editar Cheque'></i>" +
                            "</a>" + "</div>" +
                            "<div class=' col-lg-2' > " +
                            "<a href='#' class='cheque-printed'" + "data-id='" + full.id + "' " + ">" +
                            "<i class='fas fa-print' title='Generar Cheque PDF'></i>" +
                            "</a>" + "</div>" +
                            "<div class=' col-lg-2'>" +
                            "<a href='/cheques/vouchers/pdf/" + full.voucher.id + "'>" +
                            "<i class='far fa-file-pdf' title='Generar Voucher PDF'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='#' class='remove-cheque'" + " data-method='delete' data-id='" + full.id + "' " + ">" +
                            "<i class='fas fa-thumbs-down' title='Anular Cheque'></i>" +
                            "</a>" + "</div>";
                    }
                }
                //Si ya fue impreso
                else if (full.estado_cheque_id == 2) {
                    if (full.voucher == null) {
                        return "<div id='" + full.id + "' class='text-center'>" +
                            "<div class='float-left col-lg-2'>" +
                            "<a href='#' class='show-cheque' data-toggle='modal' data-target='#infoCheque' data-id='" + full.id + "' > " +
                            "<i class='fas fa-info-circle' title='Ver más'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='/cheques/entregar/" + full.id + "'class='cheque-delivered'" + ">" +
                            "<i class='fas fa-hand-paper' title='Confirmar Entrega'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-left col-lg-2'>" +
                            "<a href='#' class='get-voucher' data-toggle='modal' data-target='#voucherModal' data-method='post' data-id='" + full.id + "' data-no_cheque='" + full.no_cheque + "'>" +
                            "<i class='far fa-file' title='Generar voucher'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='#' class='remove-cheque'" + " data-method='delete' data-id='" + full.id + "' " + ">" +
                            "<i class='fas fa-thumbs-down' title='Anular Cheque'></i>" +
                            "</a>" + "</div>";
                    } else {
                        return "<div id='" + full.id + "' class='text-center'>" +
                            "<div class='float-left col-lg-2'>" +
                            "<a href='#' class='show-cheque' data-toggle='modal' data-target='#infoCheque' data-id='" + full.id + "' > " +
                            "<i class='fas fa-info-circle' title='Ver más'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='/cheques/entregar/" + full.id + "'class='cheque-delivered'" + ">" +
                            "<i class='fas fa-hand-paper' title='Confirmar Entrega'></i>" +
                            "</a>" + "</div>" +
                            "<div class=' col-lg-2'>" +
                            "<a href='/cheques/vouchers/pdf/" + full.voucher.id + "'>" +
                            "<i class='far fa-file-pdf' title='Generar Voucher PDF'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='#' class='remove-cheque'" + " data-method='delete' data-id='" + full.id + "' " + ">" +
                            "<i class='fas fa-thumbs-down' title='Anular Cheque'></i>" +
                            "</a>" + "</div>";
                    }
                } else if (full.estado_cheque_id == 3) {
                    if (full.voucher == null) { 
                        return "<div id='" + full.id + "' class='text-center'>" +
                            "<div class='float-left col-lg-2'>" +
                            "<a href='#' class='show-cheque' data-toggle='modal' data-target='#infoCheque' data-id='" + full.id + "' > " +
                            "<i class='fas fa-info-circle' title='Ver más'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='/cheques/cobrar/" + full.id + "'class='cheque-charged'" + ">" +
                            "<i class='fas fa-money-bill-wave-alt' title='Confirmar Cobro'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='#' class='remove-cheque'" + " data-method='delete' data-id='" + full.id + "' " + ">" +
                            "<i class='fas fa-thumbs-down' title='Anular Cheque'></i>" +
                            "</a>" + "</div>";
                    } else {
                        return "<div id='" + full.id + "' class='text-center'>" +
                            "<div class='float-left col-lg-2'>" +
                            "<a href='#' class='show-cheque' data-toggle='modal' data-target='#infoCheque' data-id='" + full.id + "' > " +
                            "<i class='fas fa-info-circle' title='Ver más'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='/cheques/cobrar/" + full.id + "'class='cheque-charged'" + ">" +
                            "<i class='fas fa-money-bill-wave-alt' title='Confirmar Cobro'></i>" +
                            "</a>" + "</div>" +
                            "<div class='float-right col-lg-2'>" +
                            "<a href='#' class='remove-cheque'" + " data-method='delete' data-id='" + full.id + "' " + ">" +
                            "<i class='fas fa-thumbs-down' title='Anular Cheque'></i>" +
                            "</a>" + "</div>";
                    }
                }
                //Si ya fue anulado
                else if(full.estado_cheque_id == 4) {
                   if(full.voucher == null) {
                       return "<div id='" + full.id + "' class='text-center'>" +
                           "<div class='float-left col-lg-2'>" +
                           "<a href='#' class='show-cheque' data-toggle='modal' data-target='#infoCheque' data-id='" + full.id + "' > " +
                           "<i class='fas fa-info-circle' title='Ver más'></i>" +
                           "</a>" + "</div>";
                   } else {
                       return "<div id='" + full.id + "' class='text-center'>" +
                           "<div class='float-left col-lg-2'>" +
                           "<a href='#' class='show-cheque' data-toggle='modal' data-target='#infoCheque' data-id='" + full.id + "' > " +
                           "<i class='fas fa-info-circle' title='Ver más'></i>" +
                           "</a>" + "</div>" +
                           "</div>"; 
                   }
                } else if(full.estado_cheque_id == 5) {
                    if (full.voucher == null) {
                        return "<div id='" + full.id + "' class='text-center'>" +
                            "<div class='float-left col-lg-2'>" +
                            "<a href='#' class='show-cheque'data-toggle='modal' data-target='#infoCheque' data-id='" + full.id + "' > " +
                            "<i class='fas fa-info-circle' title='Ver más'></i>" +
                            "</a>" + "</div>";
                    } else {
                        return "<div id='" + full.id + "' class='text-center'>" +
                            "<div class='float-left col-lg-2'>" +
                            "<a href='#' class='show-cheque' data-toggle='modal' data-target='#infoCheque' data-id='" + full.id + "' > " +
                            "<i class='fas fa-info-circle' title='Ver más'></i>" +
                            "</a>" + "</div>" +
                            "</div>";
                    }
                }
            }
            else {
                return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-left col-lg-12'>" +
                    "<a href='" + urlActual + "/edit/" + full.id + "' class='edit-cheque' >" +
                    "<i class='fa fa-btn fa-edit' title='Editar cheque'></i>" +
                    "</a>" + "</div>";
            }


        },
        "responsivePriority": 1
    }]

});

//Cheque impreso
$(document).on('click', 'a.cheque-printed', function (e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    let id = $this.data('id');
    console.log(id);
    alertify.confirm('Confirmar la impresion del Cheque', 'Desea imprimir el cheque',
        function () {
            $('.loader').fadeIn();
           // $.get({
           //     type: 'GET',
            //     url: '/cheques/pdf/' + id,
            // }).done(function (data) {
            //     $('.loader').fadeOut(225);
            //     chequesTable.ajax.reload();
            //     alertify.set('notifier', 'position', 'top-center');
            //     alertify.success('Cheque impreso correctamente!!');
            // });
            window.location = "/cheques/pdf/" + id;
            $('.loader').fadeOut(225);
            chequesTable.ajax.reload();
            alertify.set('notifier', 'position', 'top-center');
            alertify.success('Cheque generado correctamente en PDF!!');
        }
        , function () {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Cancelar')
        });
});

//Cheque entregado
$(document).on('click', 'a.cheque-delivered', function (e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    console.log($this.attr('href'));
    alertify.confirm('Confirmar la entrega del Cheque', 'Esta seguro que el cheque fue entregado',
        function () {
            $('.loader').fadeIn();
            $.post({
                type: 'PUT',
                url: $this.attr('href'),
            }).done(function (data) {
                $('.loader').fadeOut(225);
                chequesTable.ajax.reload();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success('Confirmación de entrega exitosa!!');
            });
        }
        , function () {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Cancelar')
        });
});


//Cheque cobrado
$(document).on('click', 'a.cheque-charged', function (e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    console.log($this.attr('href'));
    alertify.confirm('Confirmar el cobro del Cheque', 'Esta seguro que el cheque fue cobrado',
        function () {
            $('.loader').fadeIn();
            $.post({
                type: 'PUT',
                url: $this.attr('href'),
            }).done(function (data) {
                $('.loader').fadeOut(225);
                chequesTable.ajax.reload();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success('Confirmación de cobro exitosa!!');
            });
        }
        , function () {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Cancelar')
        });
});