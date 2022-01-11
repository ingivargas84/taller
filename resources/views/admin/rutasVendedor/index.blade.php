@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      MIS RUTAS
      <small>mis rutas</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Rutas</li>
    </ol>
</section>
@endsection

@section('content')
@include('admin.rutasVendedor.editModal')
@include('admin.rutasVendedor.reporteModal')
    <div class="loader loader-bar is-active"></div>
    <div class="box">
       <div class="box-header">
          <a class="btn btn-primary pull-left" data-toggle="modal" data-target="#modalVisitas">
              Obtener reporte en PDF
            </a>  
          <a class="btn btn-primary pull-right" href="{{route('rutas.new')}}">
            <i class="fa fa-plus"></i> 
            Agregar nueva Ruta
          </a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
          <table id="rutas-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
            $('.loader').fadeOut(255);
        });
        $(document).ready(function() {
            rutasTable.ajax.url("{{route('rutas.getJson')}}").load();
        });
    </script>
    <script>
    //Eliminar ruta
    $(document).on('click', 'a.remove-ruta', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Eliminar mi ruta', 'Esta seguro de eliminar la ruta', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  url: $this.attr('href'),
                  data: {'id':id},
              }).done(function (data) {
                $('.loader').fadeOut(225);
                  rutasTable.ajax.reload();
                      alertify.set('notifier','position', 'top-center');
                      alertify.success('La ruta fue eliminada correctamente!');
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
    
    <script src="{{asset('js/rutasVendedor/index.js')}}"></script>
    <script src="{{asset('js/rutasVendedor/edit.js')}}"></script>
    <script src="{{asset('js/rutasVendedor/reporte.js')}}"></script>
@endpush