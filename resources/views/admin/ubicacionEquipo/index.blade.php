@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Ubicaciones de equipo
      <small>Ubicaciones de equipo</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Ubicaciones de equipo</li>
    </ol>
</section>
@endsection

@section('content')
@include('admin.ubicacionEquipo.createModal')
@include('admin.ubicacionEquipo.editModal')
@include('admin.ubicacionEquipo.deleteModal')

    <div class="loader loader-bar is-active"></div>
    <div class="box">
      <div class="box-header">
        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#ubicacionEquipoModal">
          <i class="fa fa-plus"></i>Agregar Ubicación de equipo</a>
        </button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
          <table id="ubicacion-equipo-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
            ubicacionEquipoTable.ajax.url("{{route('ubicacionEquipo.getJson')}}").load();
        });
    </script>
    <script>
 
  </script>
    <script src="{{asset('js/ubicacionEquipo/index.js')}}"></script>
    <script src="{{asset('js/ubicacionEquipo/create.js')}}"></script>
    <script src="{{asset('js/ubicacionEquipo/edit.js')}}"></script>
    <script src="{{asset('js/ubicacionEquipo/delete.js')}}"></script>
@endpush