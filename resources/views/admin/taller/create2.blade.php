@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Orden en Taller - Registro de Reparacion
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('taller.index')}}"><i class="fa fa-list"></i> Ordenes en Taller</a></li>
        <li class="active">Reparaciones</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="DiagnosticoTallerForm" action="{{route('taller.save3', $ordenequipo)}}">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-4">
                        <h4><strong>No Comprobante:</strong> {{$ordenequipo->no_comprobante}}</h4>
                        <input type="hidden" class="form-control" name="orden" id="orden" value="{{$ordenequipo->id}}">
                    </div>
                    <div class="form-group col-sm-4">
                        <h4><strong>Equipo:</strong> {{$equipo->equipo}}</h4>
                    </div>
                    <div class="form-group col-sm-3">
                        <h4><strong>Tipo Trabajo:</strong> {{$tipo_trabajo->nombre}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-9">
                        <h4><strong>Observaciones:</strong> {{$ordenequipo->observaciones}}</h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="dias_reparacion">Dias Reparación:</label>
                        <input type="text" class="form-control" name="dias_reparacion" id="dias_reparacion" value="{{$taller->dias_reparacion}}" >
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="trabajos_realizados">Diagnóstico:</label>
                        <textarea type="text" rows=4 class="form-control" placeholder="Trabajos Realizados:" name="trabajos_realizados" id="trabajos_realizados">{{$taller->trabajos_realizados}}</textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="observaciones">Observaciones:</label>
                        <textarea type="text" rows=4 class="form-control" placeholder="Observaciones:" name="observaciones" id="observaciones">{{$taller->observaciones}}</textarea>
                    </div>
                </div>
                <br>
                <div class="row text-center">
                    <h4><strong>Agregar Detalle de Diagnóstico</strong></h4>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Servicio:</label>
                        <select class="form-control" name="servicio" id="servicio">
                            <option value="default" id= "servicio">Seleccione Servicio</option>
                            @foreach($servicio as $srv)
                            <option value="{{ $srv->id }}">{{ $srv->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Cantidad:</label>
                        <input type="number" class="form-control" title="por favor, solo ingresar números enteros"  placeholder="Cantidad:" onchange="sub()" name="cantidad" id="cantidad" value="1">
                        <input type="hidden" class="form-control" name="precio-com" id="precio-com">
                        <input type="hidden" class="form-control" name="subtotal" id="subtotal">
                    </div>
                    <div class="form-group col-sm-3">
                        <div class="text-right m-t-15" style="margin-top: 25px; margin-bottom: 10px">
                        <button id="agregar-detalleS" class="btn btn-success form-button">Agregar al detalle</button>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Producto:</label>
                        <select class="form-control" name="producto" id="producto">
                            <option value="default" id= "producto">Seleccione Producto</option>
                            @foreach($producto as $pr)
                            <option value="{{ $pr->id }}">{{ $pr->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Cantidad:</label>
                        <input type="number" class="form-control" title="por favor, solo ingresar números enteros" placeholder="Cantidad:" name="cantidadP" id="cantidadP" onchange="subP()" value="1">
                        <input type="hidden" class="form-control" name="precioP" id="precioP">
                        <input type="hidden" class="form-control" name="subtotalP" id="subtotalP">
                    </div>
                    <div class="form-group col-sm-3">
                      <div class="text-right m-t-15" style="margin-top: 25px; margin-bottom: 10px">
                        <button id="agregar-detalleP" class="btn btn-success form-button" >Agregar al detalle</button>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Nombre Extras:</label>
                        <input type="text" class="form-control" placeholder="Extra:" name="extra" id="extra">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Cantidad:</label>
                        <input type="number" class="form-control" title="por favor, solo ingresar números enteros" placeholder="CantidadE:" onchange="subE()"  name="cantidadE" id="cantidadE" value="1">
                    </div>
                    <div class="form-group col-sm-3">
                      <div class="text-right m-t-15" style="margin-top: 25px; margin-bottom: 10px">
                        <button id="agregar-detalleE" class="btn btn-success form-button" >Agregar al detalle</button>
                      </div>
                    </div>
                </div>
                <br>
                    <table id="detalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">
                    </table>
                <br>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('taller.index') }}">Regresar</a>
                    <button class="btn btn-success form-button" id="ButtonRegistraReparacion">Guardar</button>
                </div>

            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush


@push('scripts')

<script>


$("#DiagnosticoTallerForm").show(function () {

var orden_id = $("#orden").val();

var url = "/taller/getdiagnostico/" + orden_id ;

if (orden_id != "") {
    $.getJSON( url , function ( result ) {
        
        $filas = result.length;

        for(i=0; i<$filas; i++)
        {
            detalle_table.row.add({
                'servicio_id': result[i].codigo,
                'servicio': result[i].nombre,
                'cantidad': result[i].cantidad,
                'precio_unitario': result[i].precio,
                'subtotal': result[i].subtotal,
                'tipo': result[i].tipo,
        }).draw();
    }

    });
}
});


function chkflds() {
    if ($('#servicio').val() && $('#cantidad').val()) {
        return true
    }else{
        return false
    }
}

function chkfldsP() {
    if ($('#producto').val() && $('#cantidadP').val()) {
        return true
    }else{
        return false
    }
}

function chkfldsE() {
    if ($('#extra').val() && $('#cantidadE').val()) {
        return true
    }else{
        return false
    }
}

$("#servicio").change(function () {
    var codigo = $('#servicio').val();
    var url = "@php echo url('/') @endphp" + "/taller/getServicioData/" + codigo;
    $('#servicio-com-error').remove();
    $('#precio-error').remove();
    $('#precio-com').val(null);
    $.ajax({
        url: url,
        success: function(data){
            $('#precio-com').val(data[0].precio);
            var subtotal = parseFloat($('#cantidad').val()) * parseFloat($('#precio-com').val());
            $('#subtotal').val(subtotal);
          },
          error: function(){
            alertify.set('notifier', 'position', 'top-center');
            alertify.error  (
                'No se encontró el servicio. Por favor, seleccionar');
                $('#precio-com').val(null);
                $('#subtotal').val(null);
        }
    });
});



$('#agregar-detalleS').click(function(e){
      e.preventDefault();
      if(chkflds()){

          detalle_table.row.add({
              'servicio_id': $('#servicio').val(),
              'servicio': $("#servicio").find('option:selected').text(),
              'cantidad': $('#cantidad').val(),
              'precio_unitario': $('#precio-com').val(),
              'subtotal': $('#subtotal').val(),
              'tipo': 'servicio',
          }).draw();

          $('#cantidad').val(1);
          $('#precio-com').val(null);
          $('#subtotal').val(null);
          $('#servicio').val('default');
      }else{
          alertify.set('notifier', 'position', 'top-center');
          alertify.error  ('Debe seleccionar un servicio o cantidad');
      }
  });


  $("#producto").change(function () {
  var codigo = $('#producto').val();
  var url = "@php echo url('/') @endphp" + "/taller/getProductoData/" + codigo;
  $('#producto-com-error').remove();
  $('#precioP-error').remove();
  $('#precioP').val(null);
  $.ajax({
      url: url,
      success: function(data){
          $('#precioP').val(data[0].precio_venta);
          var subtotal = parseFloat($('#cantidadP').val()) * parseFloat($('#precioP').val());
          $('#subtotalP').val(subtotal);
        },
        error: function(){
          alertify.set('notifier', 'position', 'top-center');
          alertify.error  (
              'No se encontró el producto. Por favor, seleccionar');
              $('#precioP').val(null);
              $('#subtotalP').val(null);
        }
    });
});

  $('#agregar-detalleP').click(function(e){
    e.preventDefault();
    if(chkfldsP()){
      
        detalle_table.row.add({
            'servicio_id': $('#producto').val(),
            'servicio': $("#producto").find('option:selected').text(),
            'cantidad': $('#cantidadP').val(),
            'precio_unitario': $('#precioP').val(),
            'subtotal': $('#subtotalP').val(),
            'tipo': 'producto',
        }).draw();
        
        $('#cantidadP').val(1);
        $('#producto').val('default');
    }else{
        alertify.set('notifier', 'position', 'top-center');
        alertify.error  ('Debe seleccionar un Producto o Cantidad');
    }
});


$('#agregar-detalleE').click(function(e){
    e.preventDefault();
    if(chkfldsE()){
       
        detalle_table.row.add({
            'servicio_id': '0',
            'servicio': $('#extra').val(),
            'cantidad': $('#cantidadE').val(),
            'precio_unitario': 0,
            'subtotal': 0,
            'tipo': "extra",
        }).draw();
       
        $('#cantidadE').val(1);
        $('#extra').val(null);
    }else{
        alertify.set('notifier', 'position', 'top-center');
        alertify.error  ('Debe escribir un Extra o cantidad');
    }
});



$(document).on('click', '#ButtonRegistraReparacion', function(e) {
        e.preventDefault();
        
        if ($('#DiagnosticoTallerForm').valid()) {

            var arr1 = $('#DiagnosticoTallerForm').serializeArray();
            var arr2 = detalle_table.rows().data().toArray();
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST',
                url: "{{route('taller.save3')}}",
                headers: {
                    'X-CSRF-TOKEN': $('#tokenReset').val(),
                },
                data: JSON.stringify(arr3),
                dataType: 'json',
                success: function() {
                    $('#servicio').val('default');
                    $('#producto').val('default');
                    $('#trabajos_realizados').val(null);
                    $('#observaciones').val(null);
                    $('#extra').val(null);
                    detalle_table.rows().remove().draw();
                    window.location.assign('/taller')
                },
                error: function(error) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar el diagnóstico de reparación')
                }
            })
        }
    });


</script>


<script src="{{asset('js/taller/create2.js')}}"></script>
<script src="{{asset('js/taller/new.js')}}"></script>
@endpush
