var bienCotizadoTable = $('#bienCotizado-table').DataTable({
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

    "columns": [
        
    {
        "title": "Producto / Servicio.",
        "data": "producto",
        "width": "25%",
        "responsivePriority": 3,
        "render": function (data, type, full, meta) {
            return (data);
            //hacer IF PRODUCTO OR SERVICIO
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
        "title": 'Precio.',
        "data": "precio",
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
            return "<i class='fas fa-trash remove-bien' title='Eliminar detalle'></i>";

        }
    }
    ],
});
//
$('#fecha').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy'
});
//
$(document).ready(function () {
    $('#producto').val('');
    $('#cantidad').val('');
    $('#codigo').val('');
    $('#total').val('');
    $('#precio').val('');
    $('#subtotal').val('');
    $('#nombre').val('');
    $('#direccion').val('');
    $('#contacto').val('');
    $('#telefono').val('');
    $('#cliente').focus();
    //Fecha actual
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
    $("input[name='fecha']").val(getFecha());
   
    //Cliente
    $("#cliente").select2();
    $("#cliente").change(function () {
        $.getJSON('/cotizaciones/clientes/' + $('#cliente option:selected').val(), function(data) {
            $('#nombre').val(data[0].nombre_comercial);
            $('#direccion').val(data[0].direccion);
            $('#contacto').val(data[0].nombre_contacto1);
            console.log(data[0].nombre_comercial);
            $('#telefono').val(data[0].telefono);
        });
    });

    var count = 1;
    //
    $.getJSON('/cotizaciones/clientes/', function (data) {
        $.each(data, function () {
            $('#cliente').append("<option value='" + this.id + "'>" + this.nombre_comercial + "</option>");
        });
    });

    //Buscar servicios
    
    $("#servicio").select2();
    $("#servicio").change(function () {
        $.getJSON('/cotizaciones/servicios/' + $('#servicio option:selected').val(), function (data) {

            $.getJSON('/cotizaciones/servicios/' + $('#servicio option:selected').val(), function (data) {
                $('#producto').val(data[0].nombre);
                $('#cantidad').val('');
                $('#subtotal').val('');
                $('#precio').val(parseFloat(data[0].precio));

            })
        });
    });

    //
    $.getJSON('/cotizaciones/servicios/', function (data) {
        $.each(data, function () {
            $('#servicio').append("<option value='" + this.id + "'>" + this.nombre + "</option>");
        });
    });
    
    //Buscar producto por medio del codigo
    $('#codigo').focusout(function () {
        $.getJSON('/cotizaciones/productos/' + $('#codigo').val(), function (data) {
            if (data[0] != null) {
                $('#producto').val(data[0].nombre);
                $('#cantidad').val('');
                $('#subtotal').val('');
                $('#precio').val(parseFloat(data[0].precio_venta));
                $('.notif').html('');

            } else {
                $('#producto').val('');
                $('#precio').val('');
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
    //OnfocusOut se debe multiplicar la cantidad por las unidades, luego agregarlas al subtotal
    
    $('#cantidad').focusout(function () {
        
            if($('#cantidad').val() != '' && $('#precio').val() != '') {
                //Calculado subtotal y agregado
                $('#subtotal').val(parseFloat($('#cantidad').val()) * parseFloat($('#precio').val()));
            } else if ($('#precio').val() == '') {
                $('#subtotal').val('');
            }
        });

    //OnfocusOut precio
    $('#precio').focusout(function () {

        if ($('#precio').val() != '' && $('#precio').valid()  && $('#cantidad').val() != '') {
                //Calculado subtotal y agregado
                $('#subtotal').val(parseFloat($('#cantidad').val()) * parseFloat($('#precio').val()));
        }
    });
    
    
    //producto
    $('#producto').focusout(function () {
        $('#producto').valid();

    });


    $('#guardar').click(function () {
        var frm = $('#cotizacionForm');
        frm.submit(function (e) {
            e.preventDefault();
        });

        if (bienCotizadoTable.rows().data().length != 0) {
            //Validacion para producto
            $('#producto').rules('remove');
            //Validacion para cantidad
            $('#cantidad').rules('remove');

            //Validacion para precio
            $('#precio').rules('remove');
            //Validacion subtotal
            $('#subtotal').rules('remove');
            //
            // var productos = [];
            // $.each(bienCotizadoTable.rows().data(), function () {
            //     productos.push([this.producto, this.cantidad, this.precio, this.subtotal]);
            // });
            // console.log(productos[0][3]);

            if ($('#cotizacionForm').valid()) {
                save();
            } else {
                validator.focusInvalid();
            }

        } else {
            $('.notif').html(
                "<div class='alert' role='alert' style='background-color: #d9c941'>" +
                "<span style='color: black;'>Debes agregar mínimo un producto / servicio para generar la cotización</span>" +
                "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
                "<span aria-hidden='true'>&times;</span>" +
                "</button >" +
                "</div >");
        }

    });


    //validate header
    //validation


    function save() {

        //Encabezado
        var fecha;

        var cliente;
        //Obtener el encabezado 
        fecha = $("input[name='fecha']").val();
        cliente = $("#cliente").val();
        //Array de bienes
        var bienes = [];
        $.each(bienCotizadoTable.rows().data(), function () {
            bienes.push([this.producto, this.cantidad, this.precio, this.subtotal]);
        });
        
        //obtener total
        var total;
        total = $("input[name='total']").val();

        $.ajax({
            url: "/cotizaciones/save",
            type: 'POST',
            data: {
                fecha: fecha,
                cliente: cliente,
                bienes: bienes,
                total: total,
            },
            success: function (data) {
              window.location.assign('/cotizaciones?ajaxSuccess');

           },

       });
    }
});



