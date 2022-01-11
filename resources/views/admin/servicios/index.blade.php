@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Servicios
      <small>Todos los servicios</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Servicios</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.servicios.createModal')
@include('admin.servicios.editModal')

<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalServicio">
        <i class="fa fa-plus"></i>Agregar Servicio
      </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="servicios-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
    });
    $(document).ready(function() {
      servicios_table.ajax.url("{{route('servicios.getJson')}}").load();
    });
  </script>
  <script src="{{asset('js/servicios/index.js')}}"></script>
  <script src="{{asset('js/servicios/create.js')}}"></script>
  <script src="{{asset('js/servicios/edit.js')}}"></script>
@endpush