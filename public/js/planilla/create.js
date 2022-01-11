function getHeader() {
        $.ajax({
            url: "/planilla/getHeader",
            type: "GET",
            "data": function (json) { return JSON.stringify({ "Sql": 12 }); },
            "contentType": "application/json; charset=utf-8",
            "dataType": "json",
            "processData": true,
            success: function (res) {
                $.each(res.data, function (key, valor) {
                    $('#header').append(
                        "<th>" +
                        valor +
                        "</th>"
                        );
                    });
                }
            });
        }
        
        //
        function getMovs() {
            $.ajax({
                url: "/planilla/getMovs",
                type: "GET",
                "data": function (json) { return JSON.stringify({ "Sql": 12 }); },
                "contentType": "application/json; charset=utf-8",
                "dataType": "json",
                "processData": true,
                success: function (res) {
                    $.each(res.data, function (key, value) {
                        var myHtml = "";
                        //                        
                        $('#datos').append(
                            "<tr id=" + "empleadotr" + value.id +"><td>" +
                            value.nombre +
                            "</td>" +
                            "<td id='salario'>" +
                            "Q." + value.salario +
                            "</td>" +
                            $.each(value.movimientos, function(llave, valor) {
                                if(valor.tipo_calculo_id == 1) {
                                    //PORCENTAJE
                                    switch (valor.campo_pc_id) {
                                        case 1:
                                            //SUELDO BASE
                                            myHtml += "<td id='movID" + valor.id +"' class='mov" + valor.tipo_movimiento_id  + " mov'>" + "Q." +((valor.porcentaje * 100) * value.salario / 100).toFixed(2) + "</td>";
                                        break;
                                        // case 2:
                                        //     //SUELDO TOTAL       
                                        //     myHtml += "<td id='movID" + valor.id +"' class='mov" + valor.tipo_movimiento_id  + " mov'>" + (((valor.porcentaje * 100) * (value.salario + value.fijo_ingreso)) / 100).toFixed(2) + "</td>";

                                        // break;
                                        default:
                                            myHtml += "<td></td>"
                                            break;
                                    }
                                
                                } else if(valor.tipo_calculo_id == 2) {
                                    //CALCULADO
                                    switch (valor.campo_pc_id) {
                                        case 1:
                                            //SUELDO BASE
                                            myHtml += "<td data-toggle='modal' data-target='#operarCalculo' cantidad='" + (value.salario * valor.cantidad_multiplicar).toFixed(2) + "' id='movID" + valor.id + "' identificador='" + value.id + valor.id +"' class='mov" + valor.tipo_movimiento_id + " mov'>" + 0 + "</td>";
                                           break;
                                        // case 2:
                                        //         //SUELDO TOTAL
                                        //     myHtml += "<td id='movID" + valor.id +"' class='mov" + valor.tipo_movimiento_id + " mov'>" + ((valor.cantidad_multiplicar * (value.salario + value.fijo_ingreso)) / 100).toFixed(2) + "</td>";                
                                        //     break;
                                        case 3:
                                            //
                                            myHtml += "<td data-toggle='modal' data-target='#operarCalculo' cantidad='" + ((value.salario / 30 / 8) * valor.cantidad_multiplicar).toFixed(2) + "' id='movID" + valor.id + "' identificador='" + value.id + valor.id + "' class='mov" + valor.tipo_movimiento_id + " mov'>" + 0 + "</td>";
                                                //VALOR POR HORA
                                            // myHtml += "<td id='movID" + valor.id + "' class='mov" + valor.tipo_movimiento_id + " mov'>" + ((value.salario / 30 / 8) * valor.cantidad_multiplicar).toFixed(2) +"</td>" ;
                                            break;
                                        default:
                                            myHtml += "<td></td>"
                                            break;
                                    }
                                
                                } else if (valor.tipo_calculo_id == 3) {
                                    //FIJO
                                    if(valor.campo_am_id == 1) {
                                        //MANUAL
                                        myHtml += "<td id='movID" + valor.id +"' onblur='getTotal()' contentEditable class='mov" + valor.tipo_movimiento_id + " mov'></td>" ;
                                    } else if (valor.campo_am_id == 2){
                                        //AUTO
                                        myHtml += "<td id='movID" + valor.id +"' class='mov" + valor.tipo_movimiento_id + " mov'>" + "Q." + valor.cantidad_ingreso_fijo +"</td>" ;
                                    }
                                } else {
                                    if(valor.sueldoT != null) {
                                        myHtml += "<td id='sueldoT'></td>"
                                    } else if(valor.ingresoT != null) {
                                        myHtml += "<td id='ingresoT'></td>"
                                    } else if (valor.egresoT != null){
                                        myHtml += "<td id='egresoT'></td>"
                                    } else {
                                        console.log('wth');
                                    }
                                    
                                }
                            }) + 
                            myHtml +
                            "<td class='totalClass' id='total'></td>" +
                            "</tr>"  
                        ); 
                        getTotal();
                    });
                  }
            });
}



$(document).on('show.bs.modal', '#operarCalculo', function (event) {
    
    $('#cantM').empty();
    let llave = event.relatedTarget.getAttribute('identificador');
    $('#multip').val('');
    let cantidad = event.relatedTarget.getAttribute('cantidad');
    $('#myModalLabel span').text(cantidad);
    $('#cantM').val(cantidad);
    $('#idtd').val(llave);
    
});

$(document).on('click', '#operar', function () {
    let id = $('#idtd').val();
    if ($('#multip').val() != '' || $('#multip').val() != null) {
        $("td[identificador='"+ id+"']").text("Q." +(parseFloat($('#multip').val()) * parseFloat($('#cantM').val())));
        $('#operarCalculo').modal('hide');
        getTotal();
    }
});





// $(document).on('hide.bs.modal', '#operarCalculo', function (event) {
//     llave = 0;
// });   
// function you can use:
function getOnlyNumbers(str) {
    if(str.includes('Q.')) {
        return str.split('Q.')[1];
    } else {
        return str;
    }
}
// use the function:

function getTotal() {
    $('tbody tr').each(function () {
        var salario = parseFloat(getOnlyNumbers($(this).find('#salario').text()));
        var totalIngreso = salario;
        var totalEgreso = 0;
        $(this).find('.mov1').each(function () {
            var ingresos = getOnlyNumbers($(this).text());
            if(!isNaN(ingresos)){

                if (ingresos.length !== 0) {
                    totalIngreso += parseFloat(ingresos);
                }
            }
    });

        //
        $(this).find('.mov2').each(function () {
            var egresos = getOnlyNumbers($(this).text());
            if(!isNaN(egresos)) {
                if (egresos.length !== 0) {
                    totalEgreso += parseFloat(egresos);
                }
            }
        });
        $(this).find('#sueldoT').html("Q." +(totalIngreso).toFixed(2));
        $(this).find('#egresoT').html("Q." +(totalEgreso).toFixed(2));
        $(this).find('#ingresoT').html("Q." +(totalIngreso - salario).toFixed(2));
        $(this).find('#total').html("Q." + (totalIngreso - totalEgreso).toFixed(2));
    });
    getTotalPlanilla();
}


function getTotalPlanilla() {
    var suma = 0;
    $('.totalClass').each(function() {
        var tot = getOnlyNumbers($(this).text());
        if(!isNaN(tot)) {
            if(tot.length !== 0) {
                suma += parseFloat(tot);
            }
        } 
    });
    $("#resultado").val("Q." +suma.toFixed(2));
}

//
$.validator.addMethod("nombreUnico", function (value, element) {
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: "/planilla/nombreUnico/",
        data: "titulo=" + value,
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "Ya existe una planilla con ese nombre");

//

//Validations
var validator = $('#planillaForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        titulo: {
            required: true,
            nombreUnico: true,
        },
        resultado: {
            required: true,
        },
    },
    messages: {
        titulo: {
            required: "Por favor, ingrese nombre de la planilla",
        },
        resultado: {
            required: "Por favor, no campos vacios",
        },
    }
});

//click
$("#guardar").click(function (event) {
    event.preventDefault();
    if ($('#planillaForm').valid()) {
        $('#guardar').prop('disabled',true);
        savePlanilla();
    } else {
        validator.focusInvalid();
    }
});

//Save
function savePlanilla() {
    var urlActual = $("input[name='urlActual']").val();
    //$('.loader').fadeIn();
    var resultadoFinal = getOnlyNumbers($('#resultado').val());
    var titulo = $('#titulo').val();
    var Tabla = new Array();
    $('#datos tr').each(function () {
        
        //var DatosEmpleado = { 'ingresos': '' };
        //DatosEmpleado = { ingresos: Ingresos, egresos: Egresos, ingresoTotal: 0, egresoTotal: 0, total: '' }
        DatosEmpleado = { movimientos: Movimientos, ingresoTotal: 0, egresoTotal: 0, total: '' }
        
        DatosEmpleado.idEmpleado = $(this).attr('id').split('empleadotr').pop();
        //var Egresos = new Array();
        //var Ingresos = new Array();
        var Movimientos = new Array();
        
        $(this).find('.mov').each(function () { 
            if (getOnlyNumbers($(this).text()) != '' && !isNaN(getOnlyNumbers($(this).text()))) {
                Movimientos.push([$(this).attr('id').split('ID').pop(), (parseFloat(getOnlyNumbers($(this).text()))).toFixed(2)])
            }
        });
        
        $(this).find('.mov2').each(function () {
            if (getOnlyNumbers($(this).text()) != '' && !isNaN(getOnlyNumbers($(this).text()))) {
                DatosEmpleado.egresoTotal += parseFloat(getOnlyNumbers($(this).text()));
            }
        });
        $(this).find('.mov1').each(function () {
            if (getOnlyNumbers($(this).text()) != '' && !isNaN(getOnlyNumbers($(this).text()))) {
                DatosEmpleado.ingresoTotal += parseFloat(getOnlyNumbers($(this).text()));
            }
        });


        DatosEmpleado.movimientos = Movimientos;
        //DatosEmpleado.egresos = Egresos;
        DatosEmpleado.total = getOnlyNumbers($(this).find('#total').text());

        //   console.log(idEmpleado);
        Tabla.push(DatosEmpleado);
    });
    
    var TablaConverted = JSON.stringify(Tabla);
    $.ajax({
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('#tokenPlanilla').val() },
        url:"/planilla/save",
        data: {
            titulo: titulo,
            total: resultadoFinal,
            datos: TablaConverted
        },
        dataType: "json",
        success: function (data) {
            window.location.assign('/planilla');
        },
        error: function (errors) {
            var errors = JSON.parse(errors.responseText);
            if (errors.nombre != null) {
                console.log(errors.nombre);
            }
        }

    });
}




