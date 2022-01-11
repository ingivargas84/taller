@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Vendedores
      <small>Todos los vendedores</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Vendedores</li>
    </ol>
  </section>
  @endsection

@section('content')

  <div class="loader loader-bar is-active"></div>
  <div class="box">
      <div class="box-header">
        <a class="btn btn-primary pull-right" href="{{route('vendedores.new')}}">
          <i class="fa fa-plus"></i>Agregar Vendedor</a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
          <table id="vendedores-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
       vendedores_table.ajax.url("{{route('vendedores.getJson')}}").load();
    });


    //Desactivar un Vendedor
    $(document).on('click', 'a.remove-vendedor', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Desactivar Vendedor', 'Esta seguro de desactivar al vendedor', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('vendedores.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                $('.loader').fadeOut(225);
                  vendedores_table.ajax.reload();
                      alertify.set('notifier','position', 'top-center');
                      alertify.success('El vendedor fue desactivado correctamente!!');
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
  <script src="{{asset('js/vendedores/index.js')}}"></script>
@endpush