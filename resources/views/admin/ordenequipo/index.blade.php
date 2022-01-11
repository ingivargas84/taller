@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Listado de Ordenes de Trabajo
        <small>Ordenes de Trabajo</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
        <li class="active">Ordenes de Trabajo</li>
    </ol>
</section>
@endsection

@section('content')
@include('admin.ordenequipo.createGarantia')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
        <a class="btn btn-primary pull-right" href="{{route('ordenequipo.new')}}">
            <i class="fa fa-plus"></i>Agregar Orden de Trabajo</a>
        </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="orden-equipo-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
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
        $('.loader').fadeOut(225);
    });
    $(document).ready(function() {
        ordenEquipo.ajax.url("{{route('ordenequipo.getJson')}}").load();
    });
    //

    //Eliminar Orden de Trabajo
    $(document).on('click', 'a.remove-ordenequipo', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Eliminar Orden de Trabajo', 'Esta seguro de eliminarlo', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('ordenequipo.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                $('.loader').fadeOut(225);
                  ordenEquipo.ajax.reload();
                      alertify.set('notifier','position', 'top-center');
                      alertify.success('La orden de trabajo ha sido eliminada correctamente!!');
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
</script>



<script src="{{asset('js/ordenequipo/index.js')}}"></script>
<script src="{{asset('js/ordenequipo/garantia.js')}}"></script>

@endpush