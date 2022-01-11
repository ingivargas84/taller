@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Cotizaciones
      <small>Todos las cotizaciones</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Cotizaciones</li>
    </ol>
  </section>

  @endsection

@section('content')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <a class="btn btn-primary pull-right" href="{{route('cotizaciones.new')}}">
        <i class="fa fa-plus"></i>Agregar Cotización</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="cotizaciones-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      
      //MESSAGE COTIZACION SUCCESS
    if (window.location.href.indexOf("ajaxSuccess") > -1) {
          alertify.set('notifier', 'position', 'top-center');
          alertify.success('La cotización fue creada con exito!!');
    }

    if(window.location.href.indexOf("ajaxDSuccess") > -1) {
          alertify.set('notifier', 'position', 'top-center');
          alertify.success('La cotización fue eliminada con exito!!');
    }
      cotizacionesTable.ajax.url("{{route('cotizaciones.getJson')}}").load();
    });
  </script>
  
    <script>
        //Desactivar un producto
    $(document).on('click', 'a.remove-cotizacion', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Eliminar cotización', 'Esta seguro de eliminar la cotización', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('cotizaciones.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                      window.location.assign('/cotizaciones?ajaxDSuccess');
                     
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
  
  <script src="{{asset('js/cotizaciones/index.js')}}"></script>
@endpush