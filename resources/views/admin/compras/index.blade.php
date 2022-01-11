@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Compras
      <small>Todos las compras</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Compras</li>
    </ol>
  </section>

  @endsection

@section('content')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <a class="btn btn-primary pull-right" href="{{route('compras.new')}}">
        <i class="fa fa-plus"></i>Agregar Compra</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="compras-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      
      //MESSAGE COMPRA SUCCESS
    if (window.location.href.indexOf("ajaxSuccess") > -1) {
          alertify.set('notifier', 'position', 'top-center');
          alertify.success('La compra fue creada con exito!!');
    }

    if(window.location.href.indexOf("ajaxDSuccess") > -1) {
          alertify.set('notifier', 'position', 'top-center');
          alertify.success('La compra fue eliminada con exito!!');
    }
      comprasTable.ajax.url("{{route('compras.getJson')}}").load();
    });
  </script>
  
    <script>
        //Desactivar un producto
    $(document).on('click', 'a.remove-compra', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Eliminar compra', 'Esta seguro de eliminar la compra', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('compras.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                      window.location.assign('/compras?ajaxDSuccess');
                     
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
  
  <script src="{{asset('js/compras/index.js')}}"></script>
@endpush