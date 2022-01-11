@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Ordenes de Trabajo en Recepción
        <small>Registro de Contacto con el Cliente</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('ordenequipo.index')}}"><i class="fa fa-list"></i> Ordenes en Recepcion</a></li>
        <li class="active">Pago y Llamada</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="PagoTelForm" action="{{route('ordenequipo.save2', $ordenequipo)}}">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                  <input type="hidden" name="id" value="{{$ordenequipo->id}}">
                    <div class="form-group col-sm-3">
                        <h4><strong>No Orden de Trabajo:</strong> {{$ordenequipo->no_orden_trabajo}}</h4>
                    </div>
                    <div class="form-group col-sm-3">
                        <h4><strong>No Comprobante:</strong> {{$ordenequipo->no_comprobante}}</h4>
                    </div>
                    <div class="form-group col-sm-3">
                        <h4><strong>Equipo:</strong> {{$equipo->equipo}}</h4>
                    </div>
                    <div class="form-group col-sm-3">
                        <h4><strong>Cliente:</strong> {{$cliente->nombre_comercial}}</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-9">
                        <h4><strong>Observaciones:</strong> {{$ordenequipo->observaciones}}</h4>
                    </div>
                    <div class="form-group col-sm-3">
                        <h4><strong>Teléfono Cliente:</strong> {{$cliente->telefono}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <h4><strong>Fecha de Diagnóstico Taller:</strong> {{$taller->fecha_reparacion}}</h4>
                    </div>
                    <div class="form-group col-sm-6">
                        <h4><strong>Usuario Diagnóstico Taller:</strong> {{$usuario->name}}</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <h4><strong>Diagnóstico de Taller:</strong> {{$taller->trabajos_realizados}}</h4>
                    </div>
                    <div class="form-group col-sm-12">
                        <h4><strong>Observaciones de Taller:</strong> {{$taller->observaciones}}</h4>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="codigo">Total a Cobrar:</label>
                        <input type="text"  class="form-control" placeholder="Total a Cobrar (Q.)" readonly name="total_cobrar" value="{{$ordenequipo->total_cobrar}}">
                    </div>
                    <div class="form-group col-sm-4">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="autorizado_id">Autorizada/No Autorizada:</label>
                        <select class="form-control" name="autorizado_id" id="autorizado_id">
                            <option value="default">Seleccionar</option>
                            <option value="1">Autorizado</option>
                            <option value="2">No Autorizado</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="detalle_llamada">Detalle de la Llamada:</label>
                        <textarea type="text" rows=6 class="form-control" placeholder="Detalle de la Llamada:" id="detalle_llamada" name="detalle_llamada"></textarea>
                    </div>

                </div>
                <div class="row">
                  <div class="form-group col-sm-12 text-right">

                      <button id="agregar-detalle" class="btn btn-success form-button" tabindex="11">Agregar al detalle</button>
                    </div>
                </div>

                <table id="detalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">
                </table>
                <hr>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('ordenequipo.index') }}">Regresar</a>
                    <button class="btn btn-success form-button" id="ButtonPagoTel">Guardar</button>
                </div>

            </div>
        </div>
    </div>
</form>
&nbsp;
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush


@push('scripts')
<script type="text/javascript">

$.validator.addMethod("select", function (value, element, arg) {
    return arg !== value;
}, "Debe seleccionar una opción.");


var validator = $('#PagoTelForm').validate({
    ignore: [],
    onkeyup: false,
    rules: {
        autorizado_id: {
            required: true,
            select: 'default'
        }
    },
    messages: {
        autorizado_id: {
            required: "Este campo es requerido y obligatorio."
        }
    }
});




var datos  = [];
function chkflds() {
      if ($('#detalle_llamada').val()) {
          return true;
      }else{
          return false;
      }
  }

  function llamada() {
        if ($('#detalle_llamada').val()) {
            return false;
        }else{
            return true;
        }
    }

$('#agregar-detalle').click(function(e){
e.preventDefault();
if(chkflds()){
  var meses = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
  var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
  var dias = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23",
  "24","25","26","27","28","29","30","31");
  var f=new Date();
  var fecha1 = (  dias[f.getDate()] + " / " + meses[f.getMonth()] + " / " + f.getFullYear());
  var  momentoActual = new Date();
    var hora1 = momentoActual.getHours();
    var minuto = momentoActual.getMinutes();
    if(minuto < 10){
      var segundo = momentoActual.getSeconds();
      hora = hora1 + ":0" + minuto + ":" + segundo;
    }else {
      var segundo = momentoActual.getSeconds();
      hora = hora1 + ":" + minuto + ":" + segundo;
    }

    detalle_table.row.add({
        'descripcion': $('#detalle_llamada').val(),
        'hora': hora,
        'fecha': fecha1,
    }).draw();

    datos.push({
      'descripcion': $('#detalle_llamada').val(),
      'hora': hora,
      'fecha': fecha1,
    });

    //resets form data
    $('#detalle_llamada').val(null);
}else{
    alertify.set('notifier', 'position', 'top-center');
    alertify.error  ('Debe llenar la descripción de la llamada ');
}
});




    $(document).on('click', '#ButtonPagoTel', function(e){
            e.preventDefault();
            $('.loader').removeClass("is-active");
          if (llamada()) {
            if ($('#PagoTelForm').valid()) {
                $('.loader').addClass("is-active");
                var arr1 = $('#PagoTelForm').serializeArray();
                var arr2 = datos;
                var arr3 = arr1.concat(arr2);

                $.ajax({
                    type: 'POST',
                    url: "{{route('ordenequipo.save2', $ordenequipo)}}",
                    headers:{'X-CSRF-TOKEN': $('#tokenReset').val(),},
                    data: JSON.stringify(arr3),
                    dataType: 'json',
                    success: function(){
                      $('#cantidadE').val(null);
                      $('#precioE').val(null);
                      $('#extra').val(null);
                      $('#producto-nom').val(null);
                      $('#cantidadP').val(null);
                      $('#precioP').val(null);
                      $('#producto-id').val(null);
                      $('#producto').val('default');
                      $('#servicio-nom').val(null);
                      $('#cantidad').val(null);
                      $('#precio-com').val(null);
                      $('#servicio').val('default');
                      $('#servicio-id').val(null);

                        detalle_table.rows().remove().draw();
                          window.location.assign("{{route('ordenequipo.index')}}")
                    },
                    error: function(){
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error('Hubo un error al registrar el Diagnostico')
                    }
                })
            }
        }else {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('La llamada no fue agregada al detalle')
        }

        });


</script>
<script src="{{asset('js/ordenequipo/show.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/ordenequipo/create2.js')}}"></script>
@endpush
