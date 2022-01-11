var cuentaTable = $('#cuenta-table').DataTable({
    "ajax": {
        "type": "GET",
        "url": "cuentasBancarias/getJson",
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
            extend: 'excelHtml5',
            filename: 'cuentasBancarias',
        },
        {
            extend: 'csvHtml5',
            filename: 'cuentasBancarias',
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
            "responsivePriority": 5,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Nombre cuenta",
            "data": "nombre_cuenta",
            "width": "8%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "No. cuenta",
            "data": "no_cuenta",
            "width": "10%",
            "responsivePriority": 2,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Banco",
            "data": "banco.banco",
            "width": "12%",
            "responsivePriority": 5,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Estado",
            "data": "estado_id",
            "width": "6%",
            "responsivePriority": 5,
            "render": function (data, type, full, meta) {
                if (data == 1) {
                    return "Activa";
                } else {
                    return "Inactiva";
                }
            },
        },
        {
            "title": "Tipo de cuenta",
            "data": "tipo_cuenta_id",
            "width": "12%",
            "responsivePriority": 5,
            "render": function (data, type, full, meta) {
               if(data == 1) {
                    return "Monetaria";
               } else {
                   return "Ahorro";
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
               if(full.estado_id == 1) {
                   return "<div id='" + full.id + "' class='text-center'>" +
                       "<div class='float-left col-lg-6'>" +
                       "<a href='#' class='edit-cuenta' data-toggle='modal' data-target='#cuentaUpdateModal' data-id='" + full.id + "' data-nombre_edit='" + full.nombre_cuenta + "'data-banco_nombre='" + full.banco.banco + "'data-banco_id='" + full.banco_id + "' data-tipo_cuenta_id='" + full.tipo_cuenta.id + "' data-tipo_cuenta='" + full.tipo_cuenta.tipo + "'data-no_edit='" + full.no_cuenta + "'>" +
                       "<i class='fa fa-btn fa-edit' title='Editar cuenta'></i>" +
                       "</a>" + "</div>" +
                       "<div class='float-right col-lg-6'>" +
                       "<a href='#' class='remove-cuenta'" + "data-method='delete'  data-toggle='modal' data-id='" + full.id + "' data-target='#modalConfirmarAccion' " + ">" +
                       "<i class='fas fa-thumbs-down' title='Desactivar Cuenta'></i>" +
                       "</a>" + "</div>";
               } else {
                    return "<div id='" + full.id + "' class='text-center'>" +
                            "<div class='float-right col-lg-6'>" +
                            "<a href='" + urlActual + "/" + full.id + "/activar' class='activar-cuenta'" + "data-method='post' data-id='" + full.id + "' >" +
                            "<i class='fa fa-thumbs-up' title='Activar Cuenta'></i>" +
                            "</a>" + "</div>";
               }
            },
            "responsivePriority": 1
        }]

});

//Activar Cuenta bancaria
$(document).on('click', 'a.activar-cuenta', function (e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    alertify.confirm('Activar Cuenta Bancaria', 'Esta seguro de activar la cuenta',
        function () {
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                cuentaTable.ajax.reload();
                alertify.set('notifier', 'position', 'top-center');
                alertify.success('Cuenta activada con Éxito!!');
            });
        }
        , function () {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Cancelar')
        });
});