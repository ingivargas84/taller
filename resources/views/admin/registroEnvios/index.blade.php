@extends('admin.layoutadmin')
@section('header')
<section class="content-header">
    <h1>
      Registro de envíos de Equipo
      <small>Todos los envíos</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Envíos de Equipo</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.registroEnvios.modalEntregado')

<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <a class="btn btn-primary pull-right" href="{{route('envios.new')}}">
        <i class="fa fa-plus"></i> Nuevo Envío de Equipo</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="envios-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}"> 
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
      $('.loader').fadeOut(225);
      
      //MESSAGE ENVIO SUCCESS
    if (window.location.href.indexOf("ajaxSuccess") > -1) {
          alertify.set('notifier', 'position', 'top-center');
          alertify.success('El envío fue registrado con exito!!');
    }

    if(window.location.href.indexOf("ajaxDSuccess") > -1) {
          alertify.set('notifier', 'position', 'top-center');
          alertify.success('El envío fue anulado con exito!!');
    }
      enviosTable.ajax.url("{{route('envios.getJson')}}").load();
    });
  </script>
  
    <script>
        //Anular cheque
    $(document).on('click', 'a.envio-remove', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Anular envío', 'Esta seguro de anular el envío, ¡esta acción es irreversible!', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('envios.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                  $('.loader').fadeOut(225);
                  enviosTable.ajax.reload();
                  alertify.set('notifier','position', 'top-center');
                  alertify.success('El envío fue anulado correctamente!!');
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
  
  <script src="{{asset('js/registroEnvios/index.js')}}"></script>
  <script src="{{asset('js/registroEnvios/modalEntregado.js')}}"></script>
@endpush