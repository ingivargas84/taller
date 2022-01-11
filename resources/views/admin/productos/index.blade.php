@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Productos
      <small>Todos los productos</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Productos</li>
    </ol>
  </section>
  @endsection

@section('content')

  <div class="loader loader-bar is-active"></div>
  <div class="box">
      <div class="box-header">
        <a class="btn btn-primary pull-right" href="{{route('productos.new')}}">
          <i class="fa fa-plus"></i>Agregar Producto</a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
          <table id="productos-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
          </table>
          <input type="hidden" name="urlActual" value="{{url()->current()}}"> 
      </div>
      <!-- /.box-body -->
  </div>
  
@endsection

@push('styles')
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut('225');
       productos_table.ajax.url("{{route('productos.getJson')}}").load();
    });


    //Desactivar un producto
    $(document).on('click', 'a.remove-producto', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Desactivar Producto', 'Esta seguro de desactivar el producto', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('productos.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                $('.loader').fadeOut(225);
                  productos_table.ajax.reload();
                      alertify.set('notifier','position', 'top-center');
                      alertify.success('El producto fue desactivado correctamente!!');
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
  <script src="{{asset('js/productos/index.js')}}"></script>
@endpush