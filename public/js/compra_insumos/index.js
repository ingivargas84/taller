var compra_insumos_table = $('#compra_insumos-table').DataTable({
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
        'excelHtml5',
        'csvHtml5'
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
        "width": "10%",
        "responsivePriority": 1,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Proveedor",
        "data": "proveedor",
        "width": "20%",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Factura",
        "data": "factura",
        "width": "15%",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Total",
        "data": "total",
        "width": "15%",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Estado",
        "data": "estado",
        "width": "10%",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },


    {
        "title": "Fecha de Creación",
        "data": "created_at",
        "width": "15%",
        "responsivePriority": 4,
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

            if(full.estado_id == 1){
                return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-center col-lg-6'>" + 
                    "<a href='compra_insumos/show/"+full.id+"' class='show-compra' >" + 
                    "<i class='fa fa-btn fa-eye' title='Ver Compra'></i>" + 
                    "</a>" + "</div>" + 
                    "<div class='float-center col-lg-6'>" +
                    "<a href='compra_insumos/"+full.id+"/anular' class='anular-compra'"+ "data-method='post' data-id='"+full.id+"' >" + 
                    "<i class='fa fa-thumbs-down' title='Anular Compra'></i>" + 
                    "</a>" + "</div>";
            }else{
                return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-center col-lg-12'>" + 
                    "<a href='compra_insumos/show/"+full.id+"' class='show-compra' >" + 
                    "<i class='fa fa-btn fa-eye' title='Ver Compra'></i>" + 
                    "</a>" + "</div>"
            }
            
        },
        "responsivePriority": 5
    }]

});





$(document).on('click', 'a.anular-compra', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);    
    alertify.confirm('Anular Compra de Insumo', 'Esta seguro de anular la factura de compra', 
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                compra_insumos_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Compra Anulada con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancelar')
        });   
});


