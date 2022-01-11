@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Tipos de Trabajo
      <small>tipos de trabajo</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Tipos de Trabajo</li>
    </ol>
</section>
@endsection

@section('content')
@include('admin.tipoTrabajo.createModal')
@include('admin.tipoTrabajo.editModal')
    <div class="loader loader-bar is-active"></div>
    <div class="box">
      <div class="box-header">
        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#tipoTrabajoModal">
          <i class="fa fa-plus"></i>Agregar Tipo de Trabajo</a>
        </button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
          <table id="tipo-trabajo-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
            tipoTrabajoTable.ajax.url("{{route('tipoTrabajo.getJson')}}").load();
        });
    </script>
    <script>
    //Desactivar un tipo de trabajo
    $(document).on('click', 'a.remove-tipoTrabajo', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Eliminar Tipo de trabajo', 'Esta seguro de eliminar el trabajo', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('tipoTrabajo.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                $('.loader').fadeOut(225);
                  tipoTrabajoTable.ajax.reload();
                      alertify.set('notifier','position', 'top-center');
                      alertify.success('¡El tipo de trabajo fue eliminado correctamente!');
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
    <script src="{{asset('js/tipoTrabajo/index.js')}}"></script>
    <script src="{{asset('js/tipoTrabajo/create.js')}}"></script>
    <script src="{{asset('js/tipoTrabajo/edit.js')}}"></script>
@endpush