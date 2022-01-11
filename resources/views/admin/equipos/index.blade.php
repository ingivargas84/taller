@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Equipos
      <small>equipos</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Equipo</li>
    </ol>
  </section>
@endsection

@section('content')
@include('admin.equipos.createModal')
@include('admin.equipos.editModal')
  <div class="loader loader-bar is-active"></div>
  <div class="box">
      <div class="box-header">
        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#equipoModal">
          <i class="fa fa-plus"></i>Agregar Equipo</a>
        </button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
          <table id="equipo-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
          equipoTable.ajax.reload();
      });
  </script>
  <script>
     //Desactivar una equipo
    $(document).on('click', 'a.remove-equipo', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Eliminar equipo', 'Esta seguro de eliminar el equipo', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('equipos.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                $('.loader').fadeOut(225);
                  equipoTable.ajax.reload();
                      alertify.set('notifier','position', 'top-center');
                      alertify.success('El equipo fue eliminado correctamente!');
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });
  </script>
<script src="{{asset('js/equipos/index.js')}}"></script>
<script src="{{asset('js/equipos/create.js')}}"></script>
<script src="{{asset('js/equipos/edit.js')}}"></script>

@endpush