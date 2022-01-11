@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Entradas y salidas actuales
      <small>Entradas y salidas</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Movimientos de hoy</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.movimientosInOut.open')
@include('admin.movimientosInOut.openContinue')

<div class="loader loader-bar is-active"></div>
<div class="box">
  <div class="box-header">
    <a href="{{route('movimientos.previous')}}" class="btn btn-primary pull-left">Movimientos Anteriores</a>
  </a>
  @if($isClosed === null)
  @if($records === true)
  <span style="margin-left: 27%; font-size: 20px"><b>Saldo actual:</b> {{ $ultimoSaldo }}</span>
  <div class="pull-right">
    <button class="btn btn-success" data-toggle="modal" data-target="#modalContinue">Realizar registro</button>
  </div>
  @else
  <div class="pull-right">
    <button class="btn btn-success" data-toggle="modal" data-target="#modalOpen"><i class="fa fa-plus"></i> Abrir la caja</button>
  </div>
  @endif
  @elseif($isClosed === true)
  <span style="margin-left: 27%; font-size: 20px"><b>Cerrada con:</b> {{ $ultimoSaldo }}</span>
  <div class="pull-right">
    <span class="btn btn-warning"><i class="fas fa-exclamation-triangle"> Caja cerrada</i></span>
  </div>
  @elseif($isClosed === false)

  <span style="margin-left: 27%; font-size: 20px"><b>Saldo actual:</b> {{ $ultimoSaldo }}</span>
  <div class="pull-right">
    <a class="btn btn-success" data-toggle="modal" data-target="#modalContinue" href=""><i class="fa fa-plus"></i></a>
    <span class="btn btn-danger" id='closePettyCash'>Cierre caja</span>
      </div>
    @endif
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="saldo" value="{{ $ultimoSaldo }}">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="movimientos-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}"> 
        <input type="hidden" name="idCaja" id="idCaja" value="{{ $id }}"> 
        <input type="hidden" name="ultimoSaldo" id="ultimoSaldo" value="{{ $ultimoSaldo }}"> 
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box --> 

@endsection


@push('styles')


@endpush
@push('scripts')
<script>
 $(document).ready(function() {


  //Nombre unico
$.validator.addMethod("isGreater", function (value, element) {
    var valid = false;
    var urlActual = $("input[name='urlActual']").val();
    $.ajax({
        type: "GET",
        async: false,
        url: urlActual + "/isGreater",
        data: "monto=" + value,
        dataType: "json",
        success: function (msg) {
            valid = !msg;
        }
    });
    return valid;
}, "La salida debe ser menor al monto actual");



   $('.loader').fadeOut(225);
    $('#salidaForm').html('');
    movimientosTable.ajax.url("{{route('movimientos.getJson')}}").load();
    
    $('#tipo_mov').change(function() {
    if ($('#tipo_mov').val() == '2') {
        $('#salidaForm').html("<div class='bloque' style='margin-top: 55px; height: 85px'>" +
                                "<label for='desc'>Descripción:</label>" +
                                "<input type='text' name='desc' placeholder='Determine la razón de la salida' class='form-control'>" +
                                "</div>" +
                                "<div class='bloque' style='margin-bottom: -20px'>" +
                                    "<label for='receptor'>Quien recibe:</label>" +
                                    "<input type='text' name='receptor' placeholder='Escriba quien recibe' class='form-control'>" +
                                "</div>").fadeIn();
        
      //Agregar validacion al input monto para las salidas
      $('#monto').rules('add', {
                isGreater: true,
            });
            $('#monto').val('');
          } else {
        $('#monto').rules('remove');
        $('#salidaForm').html('').fadeIn();
    }
});
});
</script>
<script>
    //Cerrar caja chica
    $(document).on('click', '#closePettyCash', function(e) {
      e.preventDefault(); // does not go through with the link.
      var urlActual = $("input[name='urlActual']").val();
      var $this = $(this);
      console.log($('#idCaja').val());
      alertify.confirm('Esta seguro de cerrar caja chica', 'Esta seguro de cerrarla', 
          function(){
              $('.loader').fadeIn();
              var id = $('#idCaja').val();
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('movimientos.close')}}",
                  data: {'id':id},
              }).done(function (data) {
                  $('.loader').fadeOut(225);
                  location.replace(urlActual);
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
</script>
<script>
    //Eliminar una entrada o una salida
    $(document).on('click', 'a.remove-movimiento', function(e) {
      e.preventDefault(); // does not go through with the link.
      var urlActual = $("input[name='urlActual']").val();
      var $this = $(this);
      console.log($this.data('id'));
      console.log($('#idCaja').val());
      alertify.confirm('Esta seguro de eliminar el movimiento', 'Esta seguro de eliminarlo', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              var cajaId = $('#idCaja').val();
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('movimientos.delete')}}",
                  data: {'id':id, 'caja': cajaId},
              }).done(function (data) {
                  $('.loader').fadeOut(225);
                  location.replace(urlActual);
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
</script>
  <script src="{{asset('js/movimientosInOut/index.js')}}"></script>
  <script src="{{asset('js/movimientosInOut/createContinue.js')}}"></script>
  <script src="{{asset('js/movimientosInOut/openCash.js')}}"></script>
@endpush