var detalleCotizacionTable = $('#detalle-cotizacion-table').DataTable({
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
            "title": "id.",
            "data": "id",
            "width": "25%",
            "visible": false,
            "responsivePriority": 3,     
            "render": function (data, type, full, meta) {
                return (data);
                
            },
        },
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
            className: "edit_cantidad",
            "data": "cantidad",
            "width": "10%",
            "responsivePriority": 3,
            "render": function (data, type, full, meta) {
                return (data);
            },
        },
        {
            "title": 'Precio.',
            className: "edit_precio",
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
                return "<div class=' col-lg-4'>" +
                        "<i class='fa fa-btn fa-edit edit-bien' title='Editar cotizacion'></i>" +
                        "</div>" +
                    "<div class=' col-lg-4'>" +
                        "<i class='fas fa-trash remove-bien' title='Eliminar detalle'></i>" +
                    "</div>";     

            }
        }
    ],
});
//
$('#fecha').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy'
});

function getFecha() {

    var date = new Date();
    var dd = date.getDate();

    var mm = date.getMonth() + 1;
    var yyyy = date.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }

    if (mm < 10) {
        mm = '0' + mm;
    }
    date = dd + '-' + mm + '-' + yyyy;
    return date;
}
$('#fecha').val(getFecha());
//Cliente
$("#cliente").select2();
$("#cliente").change(function () {
    $.getJSON('/cotizaciones/clientes/' + $('#cliente option:selected').val(), function (data) {
        $('#nombre').val(data[0].nombre_comercial);
        $('#direccion').val(data[0].direccion);
        $('#contacto').val(data[0].nombre_contacto1);
        $('#telefono').val(data[0].telefono);
        $('#clienteId').val(data[0].id);
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
        if($('#bienActualizar').val() == '') {

            $.getJSON('/cotizaciones/servicios/' + $('#servicio option:selected').val(), function (data) {
                $('#producto').val(data[0].nombre);
                $('#subtotal').val('');
                $('#cantidad').val('');
                $('#precio').val(parseFloat(data[0].precio));
                
            })
        } else {
            $('#componenteP').append("<label class='error' for='producto'>Antes debes actualizar el detalle</label>");
        }
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
        if ($('#bienActualizar').val() == '') { 
            if (data[0] != null) {
                $('#producto').val(data[0].nombre);
                $('#cantidad').val('');
                $('#subtotal').val('');
                $('#bienActualizar').val('');
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
        } else {
            $('#componenteP').append("<label class='error' for='producto'>Antes debes actualizar el detalle</label>");

        }
        
    });
});
//OnfocusOut se debe multiplicar la cantidad por las unidades, luego agregarlas al subtotal

$('#cantidad').focusout(function () {

    if ($('#cantidad').val() != '' && $('#precio').val() != '') {
        //Calculado subtotal y agregado
        $('#subtotal').val(parseFloat($('#cantidad').val()) * parseFloat($('#precio').val()));
    } else if ($('#precio').val() == '') {
        $('#subtotal').val('');
    }
});

//OnfocusOut precio
$('#precio').focusout(function () {

    if ($('#precio').val() != '' && $('#precio').valid() && $('#cantidad').val() != '') {
        //Calculado subtotal y agregado
        $('#subtotal').val(parseFloat($('#cantidad').val()) * parseFloat($('#precio').val()));
    }
});

//Editar campos

//Hora de actualizar
$('#actualizar').click(function () {
    var frm = $('#cotizacionUpdateForm');
    frm.submit(function (e) {
        e.preventDefault();
    });
    
    if (detalleCotizacionTable.rows().data().length != 0) { 
        //Validacion para producto
        $('#producto').rules('remove');
        //Validacion para cantidad
        $('#cantidad').rules('remove');

        //Validacion para precio
        $('#precio').rules('remove');
        //Validacion subtotal
        $('#subtotal').rules('remove');
        
        
        if ($('#cotizacionUpdateForm').valid()) {
            if ($('#bienActualizar').val() == '') {
                update();
            } else {
                $('#componenteP').append("<label id='mensajeActualizar' style='display:block; color: red' for='producto'>Antes debes actualizar el detalle</label>");
                console.log('heyy');
            }
        } else {
            validator.focusInvalid();
        }
    } else {
        $('.notif').html(
            "<div class='alert' role='alert' style='background-color: #d9c941'>" +
            "<span style='color: black;'>Debes contar con mínimo un Producto / Servicio para actualizar la cotización</span>" +
            "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
            "<span aria-hidden='true'>&times;</span>" +
            "</button >" +
            "</div >");
    }


    function update() {
        //Encabezado
        var fecha;
        var cliente;
        //Obtener el encabezado 
        fecha = $("input[name='fecha']").val();
        cliente = $("#clienteId").val();
        
        //Obtener los bienesEliminados

        //Obtener los datos de la tabla
        bienes = [];
        $.each(detalleCotizacionTable.rows().data(), function () {
       
            bienes.push([this.id, this.producto, this.cantidad, this.precio, this.subtotal]);
           
        });

        //obtener total
        var total;
        total = $("input[name='total']").val();
        //Actualizar
        console.log(fecha);        
        console.log("cliente id " + cliente);
        console.log(bienes);
        console.log(bienesEliminados);
        console.log(total);
        $.ajax({
            url: "/cotizaciones/" + $("input[name='id']").val() + "/update",
            type: 'PUT',
            headers: { 'X-CSRF-TOKEN': $('#tokenCotizacionEdit').val() },
            dataType: 'json',
            contentType: "application/json",
            data: {
                fecha: fecha,
                cliente: cliente,
                bienes: bienes,
                bienesEliminados: bienesEliminados,
                total: total,
            },
            success: function (data) {
              window.location.assign('/cotizaciones?ajaxUpdateSuccess');
                //alert('Okay');
            },

        });
    }
 

}); 
