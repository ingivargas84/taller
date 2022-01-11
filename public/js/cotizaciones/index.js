var cotizacionesTable = $('#cotizaciones-table').DataTable({
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
            filename: 'cotizaciones',
        },
        {
            extend: 'csvHtml5',
            filename: 'cotizaciones',
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
        "data": "no_cotizacion",
        "width": "15%",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
                return ('00' + data + '-' + full.anio);
        },
    },
    {
        "title": "Cliente.",
        "data": "cliente.nombre_comercial",
        "width": "15%",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
    {
        "title": "Fecha",
        "data": "fecha",
        "width": "20%",
        "responsivePriority": 3,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Total",
        "data": "total",
        "width": "20%",
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
            if (rol_user == 'Super-Administrador' || rol_user == 'Administrador') {
                return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class=' col-lg-4'>" +
                    "<a href='" + urlActual + "/show/" + full.id + "' class='show-cotizacion' >" +
                    "<i class='fas fa-info-circle' title='Ver cotización'></i>" +
                    "</a>" + "</div>" +
                    "<div class=' col-lg-4'>" +
                    "<a href='" + urlActual + "/edit/" + full.id + "' class='edit-cotizacion' >" +
                    "<i class='fa fa-btn fa-edit' title='Editar cotizacion'></i>" +
                    "</a>" + "</div>" +
                    "<div class=' col-lg-4'>" +
                    "<a href='#' class='remove-cotizacion'" + " data-method='delete' data-id='" + full.id + "' " + ">" +
                    "<i class='fas fa-trash' title='Eliminar cotización'></i>" +
                    "</a>" + "</div>";
            }
            else {
                return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class=' col-lg-6'>" +
                    "<a href='" + urlActual + "/show/" + full.id + "' class='show-cotizacion' >" +
                    "<i class='fas fa-info-circle' title='Ver cotización'></i>" +
                    "</a>" + "</div>" +
                    "<div class='float-left col-lg-6'>" +
                    "<a href='" + urlActual + "/edit/" + full.id + "' class='edit-cotizacion' >" +
                    "<i class='fa fa-btn fa-edit' title='Editar cotizacion'></i>" +
                    "</a>" + "</div>";
            }


        },
        "responsivePriority": 5
    }]

});


