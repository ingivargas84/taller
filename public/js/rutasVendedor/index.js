var rutasTable = $('#rutas-table').DataTable({
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
            filename: 'rutas_vendedor'
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
        "title": "No.",
        "data": "id",
        "width": "7%",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        }
    },
    {
        "title": "Fecha",
        "data": "fecha",
        "width": "10%",
        "responsivePriority": 4,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
    {
        "title": "No. orden",
        "data": "orden_equipo.no_orden_trabajo",
        "width": "10%",
        "responsivePriority": 4,
        "defaultContent": "No establecido",
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
    {
        "title": "Cliente",
        "data": "cliente.nombre_comercial",
        "width": "10%",
        "responsivePriority": 3,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
    {
        "title": "Dirección",
        "data": "cliente.direccion",
        "width": "10%",
        "responsivePriority": 5,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
    {
        "title": "Telefono",
        "data": "cliente.telefono",
        "width": "10%",
        "responsivePriority": 5,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },
        {
            "title": "Correo",
            "data": "cliente.correo_electronico",
            "width": "10%",
            "responsivePriority": 5,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
    {
        "title": "Observaciones",
        "data": "observaciones",
        "width": "20%",
        "responsivePriority": 3,
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
            if(full.estado_id == 1) {
                return "<div class='float-left col-lg-6'>" +
                "<a href='#' class='edit-ruta' data-toggle='modal' data-target='#modalUpdateRuta' data-id='" + full.id + "' data-nombre='" + full.nombre + "' >" +
                "<i class='fa fa-btn fa-edit' title='Editar Ruta'></i>" +
                "</a>" + "</div>" +
                "<div class='float-right col-lg-6'>" +
                "<a href='misRutas/delete/" + full.id + "' class='remove-ruta'" + "data-method='delete'  data-toggle='modal' data-id='" + full.id + "' data-target='#modalConfirmarAccion' " + ">" +
                "<i class='fa fa-thumbs-down' title='Desactivar Ruta'></i>" +
                "</a>" + "</div>";          
            } else {

            }
        },
        "responsivePriority": 1
    }]
});

