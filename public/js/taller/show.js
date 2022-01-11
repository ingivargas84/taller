var detalle_table = $('#detalle-table').DataTable({
    "ajax": {
        "type": "GET",
        "url": "/taller/getEditarJson/" + $("input[name='id']").val() + '/',
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
      "title": "Código",
      "data": "id",
      "width": "15%",
      "className": "text-center",
      "responsivePriority": 2,
      "render": function (data, type, full, meta) {
          return (data);
      },
      },
        {
        "title": "nombre",
        "data": "nombre",
        "width": "15%",
        "className": "text-center",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "cantidad",
        "data": "cantidad",
        "width": "15%",
        "className": "text-right",
        "responsivePriority": 4,
        "render": function (data, type, full, meta) {
            return(data);
        },
    },

    {
        "title": "precio",
        "data": "precio",
        "width": "15%",
        "className": "text-center",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Subtotal",
        "data": "subtotal",
        "width": "15%",
        "className": "text-right",
        "responsivePriority": 4,
        "render": function (data, type, full, meta) {
            return 'Q. ' + (data);
        },
    },

        {
            "title": "Acciones",
            "orderable": false,
            "width": "10%",
            "className": "text-center",
            "render": function (data, type, full, meta) {
                var rol_user = $("input[name='rol_user']").val();
                var urlActual = $("input[name='urlActual']").val();
                        if (full.estado != null){
                        return  "<div class='float-right col-lg-12'>" +
                              "<a href='/taller/delete/ " + full.id +" ' class='remove-detail' data-method='delete' data-id='" + full.id + "'>" +
                              "<i class='fas fa-trash-alt' title='Eliminar Diagnóstico'></i>" +
                              "</a>" + "</div></div>";
                        }else {
                        return  "<div class='float-right col-lg-12'>" +
                              "<a href='#' class='remove-detail' data-method='delete' data-id='" + full.id + "'>" +
                              "<i class='fas fa-trash-alt' title='Eliminar Compra'></i>" +
                              "</a>" + "</div></div>";
                        }

            },
            "responsivePriority": 5
        }]

    });

    $(document).on('click', 'a.remove-detail', function (e) {
        e.preventDefault(); // does not go through with the link.
        var $this = $(this);
        alertify.confirm('Eliminar Detalle', 'Esta seguro de eliminar el detalle',
            function () {
                $('.loader').fadeIn();
                //removes the table row
                detalle_table.row($this.parents('tr')).remove().draw();
                datos.push({
                    'id': "",
                    'Eliminar': $this.data("id"),
                });
                //recalculates total after deletion
                if (!detalle_table.data().count()) {
                    $('#total').val(null);
                    $('#descuento').val(null);
                }else{
                    var total = 0;
                    detalle_table.column(4).data().each(function (value, index) {
                        total = total + parseFloat(value);
                        $('#total').val(total);

                    });


                }
            }
            , function () {
                alertify.set('notifier', 'position', 'top-center');
                alertify.warning('Cancelar')
            });
    });
