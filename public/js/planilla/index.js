var planillasTable = $('#planillas-table').DataTable({
    //"ajax": "/proveedores/getJson",
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',

    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
    ],

    "buttons": [
    'pageLength',
    'excelHtml5',
    'csvHtml5'
    ],

    "paging": true,
    "language": {
        "sdecimal":        ".",
        "sthousands":      ",",
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'desc'],

    "columns": [
        {
            "title": "Código.",
            "data": "no_planilla",
            "width": "10%",
            "responsivePriority": 1,
            "render": function (data, type, full, meta) {
                return ("00" +data + "-" + full.anio);
            },
    }, 
    {
        "title": "Título.",
        "data": "titulo",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data)
        },
    }, 
    
    {
        "title": "Fecha",
        "data": "fecha_planilla",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);
        },
    }, 
    {
        "title": "Total",
        "data": "total",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);
        },
    },
    {
        "title": "Estado",
        "data": "estado.estado",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);
        },
    },
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "20%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();
            //Creada
            return "<div class='text-center'>" + "</div>"; 
            // if (full.estado_planilla_id == 1){
            //     return "<div id='" + full.id + "' class='text-center'>" + 
            //     "<div class='float-left col-lg-4'>" + 
            //     "<a href='"+urlActual+"/edit/"+full.id+"' class='edit-proveedor' >" + 
            //     "<i class='fa fa-btn fa-edit' title='Editar Proveedor'></i>" + 
            //     "</a>" + "</div>" + 
            //     "<div class='float-right col-lg-4'>" + 
            //     "<a href='#' class='remove-proveedor' data-method='delete' data-id='"+full.id+"' data-target='#modalConfirmarAccion' data-toggle='modal'>" + 
            //     "<i class='fa fa-thumbs-down' title='Desactivar Proveedor'></i>" + 
            //     "</a>" + "</div>";
            // //Anulada
            // } else if (full.estado_planilla_id == 2){
            //     if(rol_user == 'Super-Administrador' || rol_user == 'Administrador'){
            //         return "<div id='" + full.id + "' class='text-center'>" + 
            //         "<div class='float-right col-lg-6'>" + 
            //         "<a href='"+urlActual+"/"+full.id+"/activar' class='activar-proveedor'"+ "data-method='post' data-id='"+full.id+"' >" + 
            //         "<i class='fa fa-thumbs-up' title='Activar Proveedor'></i>" + 
            //         "</a>" + "</div>";
            //     }else{
            //         return "<div id='" + full.id + "' class='text-center'>" + "</div>";
            //     }
            // //Liquidada
            // } else{

            // }
             
            
        },
        "responsivePriority": 5
    }
]

});


$(document).on('click', 'a.activar-proveedor', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);    
    alertify.confirm('Activar Proveedor', 'Esta seguro de activar el proveedor', 
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                proveedores_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Proveedor Activado con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancelar')
        });   
});

