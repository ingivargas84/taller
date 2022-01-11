var requi_insumos_table = $('#requi_insumos-table').DataTable({
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
        "title": "Usuario que Solicita",
        "data": "name",
        "width": "20%",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Estado Requisición",
        "data": "estado_requisicion",
        "width": "15%",
        "responsivePriority": 2,
        "render": function (data, type, full, meta) {
            return (data);
        },
    },

    {
        "title": "Fecha Requisición",
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
        "width": "10%",
        "render": function (data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();

            if(full.estado_requisicion_id == 1){
                if(rol_user == 'Super-Administrador' || rol_user == 'Administrador'){
                    return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-center col-lg-4'>" + 
                    "<a href='requi_insumos/show/"+full.id+"' class='show-requisicion' >" + 
                    "<i class='fa fa-btn fa-eye' title='Ver Requisición'></i>" + 
                    "</a>" + "</div>" +
                    "<div class='float-center col-lg-4'>" +
                    "<a href='requi_insumos/"+full.id+"/rechazarequi' class='rechazar-requisicion' >" + 
                    "<i class='far fa-times-circle' title='Rechazar Requisicion'></i>" + 
                    "</a>" + "</div>" +
                    "<div class='float-center col-lg-4'>" +
                    "<a href='requi_insumos/"+full.id+"/autorizar' class='autorizar-requi'"+ "data-method='post' data-id='"+full.id+"' >" + 
                    "<i class='far fa-calendar-check' title='Autorizar Requisicion'></i>" + 
                    "</a>" + "</div>" + "</div>";
                }else{
                    return "<div id='" + full.id + "' class='text-center'>" + "</div>";
                }
            }else if(full.estado_requisicion_id == 3 ){
                if(rol_user == 'Super-Administrador' || rol_user == 'Administrador' || rol_user == 'Asistente'){
                    return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-center col-lg-6'>" + 
                    "<a href='requi_insumos/show/"+full.id+"' class='show-requisicion' >" + 
                    "<i class='fa fa-btn fa-eye' title='Ver Requisición'></i>" + 
                    "</a>" + "</div>" +
                    "<div class='float-center col-lg-6'>" +
                    "<a href='requi_insumos/"+full.id+"/entregar' class='entregar-requi'"+ "data-method='post' data-id='"+full.id+"' >" + 
                    "<i class='fas fa-truck-loading' title='Entregar Requisicion'></i>" + 
                    "</a>" + "</div>" + "</div>";
                }else{
                    return "<div id='" + full.id + "' class='text-center'>" + "</div>";
                }
            }else{
                return "<div id='" + full.id + "' class='text-center'>" + "</div>" +
                    "<div class='float-center col-lg-12'>" + 
                    "<a href='requi_insumos/show/"+full.id+"' class='show-requisicion' >" + 
                    "<i class='fa fa-btn fa-eye' title='Ver Requisición'></i>" + 
                    "</a>" + "</div>" + "</div>" ;
            }
            
        },
        "responsivePriority": 5
    }]

});



$(document).on('click', 'a.autorizar-requi', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);    
    alertify.confirm('Autorizar Requisición de Insumos', 'Esta seguro de autorizar la requisición de insumos', 
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                requi_insumos_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Requisición autorizada con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancelar')
        });   
});


$(document).on('click', 'a.entregar-requi', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);    
    alertify.confirm('Entregar Requisición de Insumos', 'Esta seguro de entregar la requisición de insumos', 
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                requi_insumos_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Requisición entregada con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancelar')
        });   
});

