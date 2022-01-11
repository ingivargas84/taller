@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Registro de movimientos anteriores
      <small>Todas las entradas y salidas</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i>Inicio</a></li>
      <li class="active">Movimientos</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.movimientosInOut.reporte')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
    <a href="{{route('movimientos.index')}}" class="btn btn-primary pull-left">Ver Movimiento Actual</a>
    </a>
      <a class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalReporte">Obtener reporte</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="pmovimientos-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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

    pmovimientosTable.ajax.url("{{route('movimientos.getPrevious')}}").load();

 });
</script>
  <script src="{{asset('js/movimientosInOut/previous.js')}}"></script>
    <script src="{{asset('js/movimientosInOut/reporte.js')}}"></script>
@endpush