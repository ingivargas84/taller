var productosTable = $('#productos-table').DataTable({
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',
    "buttons": [
        
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
            "title": "Producto.",
            "data": "producto",
            "width": "25%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": "Cantidad.",
            "data": "cantidad",
            "width": "10%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": 'Precio de compra.',
            "data": "precio_compra",
            "width": "10%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                return 'Q. ' + (data);
            },
        },
        {
            "title": 'Subtotal',
            "data": "subtotal",
            "width": "10%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                return 'Q. ' + (data);
            },
        },
        {
            "title": "Acciones",
            "orderable": false,
            "width": "20%",
            "render": function (data, type, full, meta) {
                    return "<i class='fas fa-trash remove-producto' title='Eliminar producto'></i>";
                        
            }
        }
    ],
});

$('#fecha_compra').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy'
});
//
$('#fecha_factura').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy'
});

$(document).ready(function() {
    $('#producto').val('');
    $('#cantidad').val('');
    $('#codigo').val('');
    $('#total').val('');
    $('#precio_compra').val('');

    function getFecha() {
        let date = new Date()

        let day = date.getDate()
        let month = date.getMonth() + 1
        let year = date.getFullYear()

        if (month < 10) {
            return `${day}-0${month}-${year}`;
        } else {
            return `${day}-${month}-${year}`;
        }
    }
    //$("input[name='fecha_compra']").val(new Date().toDateInputValue());
    $("input[name='fecha_factura']").val(getFecha());
    $("input[name='fecha_compra']").val(getFecha());
   
    //proveedor
    $("#proveedor").select2();
    $("#proveedor").change(function() {
        console.log($('#proveedor option:selected').val());
        
    });
   
    var count = 1;
    //
    $.getJSON('/compras/proveedores/', function(data){
        $.each(data, function() {
            $('#proveedor').append("<option value='"+ this.id +"'>" + this.nombre_legal +"</option>");
        });
    });
    //Buscar producto por medio del codigo
    $('#codigo').focusout(function() {
        $.getJSON('/compras/productos/' + $('#codigo').val(), function (data) {
            if (data[0] != null) {
                $('#producto').val(data[0].nombre);
                $('.notif').html('');
                
            } else {
                $('#producto').val('');
                $('.notif').html(
                    "<div class='alert' role='alert' style='background-color: #d9c941'>" +
                    "<span style='color: black;'>Producto no encontrado</span>" +
                    "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
                    "<span aria-hidden='true'>&times;</span>" +
                    "</button >" +
                    "</div >");
            }
        });
    });

    //OnfocusOut producto
    //producto
        $('#producto').focusout(function() {
            $('#producto').valid();

        });
    
 
    $('#guardar').click(function() {
        var frm = $('#compraForm');
        frm.submit(function (e) {
            e.preventDefault();
        });

     if (productosTable.rows().data().length != 0) {
         //Validacion para producto
         $('#producto').rules('remove');
         //Validacion para cantidad
         $('#cantidad').rules('remove');

         //Validacion para precio
         $('#precio_compra').rules('remove');
        //
        // var productos = [];
        // $.each(productosTable.rows().data(), function () {
        //     productos.push([this.producto, this.cantidad, this.precio_compra, this.subtotal]);
        // });
        // console.log(productos[0][3]);
        
         if($('#compraForm').valid()) {
             
             
             saveCompra();
         } else {
             validator.focusInvalid();
         }
    
        } else {
             $('.notif').html(
                 "<div class='alert' role='alert' style='background-color: #d9c941'>" +
                 "<span style='color: black;'>Debes agregar mínimo un producto para generar la compra</span>" +
                 "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
                 "<span aria-hidden='true'>&times;</span>" +
                 "</button >" +
                 "</div >");
        }
        
    });

    
    //validate header
    //validation


function saveCompra() {
    
    //Encabezado
    var fecha_factura;
    var fecha_compra;
    var serie;
    var no_factura;
    var proveedor;
    //Obtener el encabezado 
    fecha_factura = $("input[name='fecha_factura']").val();
    fecha_compra = $("input[name='fecha_compra']").val();
    serie = $("input[name='serie']").val();
    no_factura = $("input[name='no_factura']").val();
    proveedor = $("#proveedor").val();
    //Array de productos
    var productos = [];
    $.each(productosTable.rows().data(), function () {
        productos.push([this.producto, this.cantidad, this.precio_compra, this.subtotal]);
    });
    //obtener total
    var total;
    total = $("input[name='total']").val();

    $.ajax({
        url: "/compras/save",
        type: 'POST',
        data: {
            fecha_factura: fecha_factura,
            fecha_compra: fecha_compra,
            serie: serie,
            no_factura: no_factura,
            proveedor: proveedor,
            productos: productos,
            total: total,
        },
        success: function (data) {
            window.location.assign('/compras?ajaxSuccess');
                    
        },

    });
}

});



