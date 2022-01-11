var detalle_table = $('#detalle-table').DataTable({
    "ajax": {
        "type": "GET",
        "url": "/ordeneequipo/getLlamadasJson/" + $("input[name='id']").val() + '/',
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
      "title": "Fecha",
      "data": "fecha",
      "width": "15%",
      "className": "text-center",
      "responsivePriority": 2,
      "render": function (data, type, full, meta) {
          return ( data);
        },
      },
      {
      "title": "Hora",
      "data": "hora",
      "width": "15%",
      "className": "text-center",
      "responsivePriority": 2,
      "render": function (data, type, full, meta) {
          return (data);
        },
      },
        {
        "title": "Descripción",
        "data": "descripcion",
        "width": "15%",
        "className": "text-center",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },



        ]

    });
