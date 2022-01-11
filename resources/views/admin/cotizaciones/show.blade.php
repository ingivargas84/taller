@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      COTIZACIÓN NO. 00{{ $cot->no_cotizacion }}-{{ $cot->anio }}
      <small>Todos los registros</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li><a href="{{route('cotizaciones.index')}}">Cotizaciones</a></li>
      <li class="active">Detalle</li>
    </ol>
  </section>

  @endsection

@section('content')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <input type="hidden" name="id" value='{{ $cot->id }}'>
    <div class="box-header">
      <div style='display: flex; justify-content: space-around; font-size: 17px;'>
        <span><b>Fecha Cotizacion. </b> {{ $cot->fecha }}</span>
        <span><b>Cliente. </b> {{ $cot->cliente->nombre_comercial }}</span>
        <span><b>Total. </b> {{ $cot->total }}</span>
        <input type="hidden" name="idCot" value="{{ $cot->id }} ">
        <input type="hidden" id="idCot" value="{{ $cot->id }}">
      </div>
      <br>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="detalle-cotizacion-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      if (window.location.href.indexOf("ajaxSuccess") > -1) {
            alertify.set('notifier','position', 'top-center');
            alertify.success('El detalle fue eliminado correctamente!!');
    }
        detalleCotizacionTable.ajax.reload();
    });
  </script>
  <script>
        //Desactivar un producto
    $(document).on('click', 'a.remove-bien', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      var id = $this.data('id');
      console.log(id);
      alertify.confirm('Eliminar Producto / Servicio', 'Esta seguro de eliminarlo', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('cotDetail.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                 $.getJSON('/cotizaciones/getCot/' + $('#idCot').val(), function(data) {
                   if(data[0].total == 0) {
                     window.location.assign('/cotizaciones' + "?ajaxDSuccess");
                  } else {
                     window.location.assign('/cotizaciones/show/' + $("input[name='idCot']").val() + "?ajaxSuccess")
                  }
                 });    
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
  <script src="{{asset('js/cotizaciones/show.js')}}"></script>
@endpush