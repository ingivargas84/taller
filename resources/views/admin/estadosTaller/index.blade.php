@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Estados de taller
      <small>Estados de taller</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Estados de taller</li>
    </ol>
</section>
@endsection

@section('content')
@include('admin.estadosTaller.createModal')
@include('admin.estadosTaller.editModal')
    <div class="loader loader-bar is-active"></div>
    <div class="box">
      <div class="box-header">
        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#estadosTallerModal">
          <i class="fa fa-plus"></i>Agregar Estado de taller</a>
        </button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
          <table id="estados-taller-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
            estadosTallerTable.ajax.url("{{route('estadosTaller.getJson')}}").load();
        });
    </script>
    <script>
    //Desactivar un Estado de taller
    $(document).on('click', 'a.remove-estadosTaller', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Eliminar Estado de taller', 'Esta seguro de eliminar el estado', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('estadosTaller.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                $('.loader').fadeOut(225);
                  estadosTallerTable.ajax.reload();
                      alertify.set('notifier','position', 'top-center');
                      alertify.success('El estado de taller fue eliminado correctamente!');
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
    
    <script src="{{asset('js/estadosTaller/index.js')}}"></script>
    <script src="{{asset('js/estadosTaller/create.js')}}"></script>
    <script src="{{asset('js/estadosTaller/edit.js')}}"></script>
@endpush